<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Repositories\Contracts\FinancialRatingRepository as FrRepository;
use Delos\Dgp\Repositories\Contracts\PaymentTypeRepository;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Delos\Dgp\Repositories\Contracts\RequestRepository;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Delos\Dgp\Entities\SupplierExpenses;
use Delos\Dgp\Entities\VoucherType;
use Delos\Dgp\Entities\PaymentTypeProviders;
use Delos\Dgp\Entities\DescriptionExpense;
use Delos\Dgp\Entities\Provider;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\Contracts;
use Delos\Dgp\Events\SavedSupplierExpense;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class SupplierExpensesController  extends AbstractController
{

    public function index()
    {
        $index = [
            'companies'                       => app(CompanyRepository::class)->getPairs(),
            'projects'                        => app(ProjectRepository::class)->getPairs(),
            'providers'                           => Provider::all()->pluck('social_reason', 'id'),
            'frs'                             => app(FrRepository::class)->pluck('cod', 'id'),
            'companiesWithOutPartnerBusiness' => app(CompanyRepository::class)->getPairs(false),
            'expenses' => $this->searchIndex()->paginate(15),
            'companiesDown' => app(CompanyRepository::class)->findWhereIn('name',['DELOS SERVIÇOS E SISTEMAS','DELOS CONSULTORIA'])->pluck('name','id')

        ];

        if ( $this->isFileDownload() ) {
            $data     =  $this->transformer($this->searchIndex()->get());
            $filename = $this->getReportFilename();
            $this->download($data, $filename);
        }


        return view('supplier-expenses.index', $index);
    }

    public function searchIndex()
    {
        $data = $this->request->all();
        $providers = !isset($data['providers']) || !is_array($data['providers']) ? false : $data['providers'];
        $projects = !isset($data['projects']) || !is_array($data['projects']) ? false : $data['projects'];;
        $deleted = isset($data['deleted_at']) ? $data['deleted_at'] : 'whereNull';
        $period = isset($data['period']) ? str_replace(' ', '', $data['period']) : '';
        $search =  isset($data['search']) ? $data['search']: null;
        $query = SupplierExpenses::whereHas('project', function ($query) use ($deleted) {
            switch ($deleted) {
                case 'whereNotNull':
                    $query->where('deleted_at', '!=', null);
                    break;

                case 'whereNull':
                    $query->where('deleted_at', '=', null);
                    break;

                case '':
                    $query->where('deleted_at', '!=', null)->orWhere('deleted_at', '=', null);
                    break;
            }
        });

        if($providers){
            $query = $query->whereIn('provider_id', $data['providers']);
        }

        if($period){
            $period = explode('-',$period);
            $start = Carbon::createFromFormat('d/m/Y',$period[0]);
            $end = Carbon::createFromFormat('d/m/Y',$period[1]);;
            $query = $query->whereBetween('issue_date',[$start,$end]);
        }

        if($projects){
            $query = $query->whereIn('project_id',$projects);
        }

        if($search){
            $query = $query->where('voucher_number','like','%'.$search.'%');
        }

        return $query->orderBy('issue_date','desc');
    }

    private function transformer($data){
        $transformer =[];
        foreach($data as $item){
            $transformer[] = [
                'id' =>$item->id,
                'project' =>$item->project->compiled_cod,
                'voucher_number' =>$item->voucher_number,
                'voucher' =>$item->voucherType->name,
                'issue_date'=>$item->issue_date->format('d/m/Y'),
                'value' =>(double)str_replace(',','.',str_replace('.','',$item->value)),
                'payment_type_provider'=>$item->paymentTypeProvider->name,
                'description'=>$item->description_id,
                'note' => $item->note,
                'provider_id'=>$item->provider->name,
                's3_name'=>$item->import ? $item->s3_name:$item->url_file,
                'export' =>$item->exported ? 'Exportado' : 'Não Exportado',
                'import' =>$item->import ? 'Sim':'Não'
              ];
        }

        return $transformer;
    }

    protected function getVariablesForCreateView(): array
    {
        return [
            'paymentTypes' => PaymentTypeProviders::where('ative',true)->get()->pluck('name', 'id'),
            'vouchers' => VoucherType::all()->pluck('name', 'id'),
            'descriptions' => DescriptionExpense::all()->pluck('name', 'name'),
            'providers' => Provider::all()->pluck('social_reason', 'id'),
            'establishment' => ['001' => 'DELOS CONSULTORIA', '007' => 'DELOS SERVIÇOS E SISTEMAS'],
        ];
    }
    public function store()
    {
        try {
            $data = $this->getDataToStore();

            foreach ($data as $key => $value) {
                $this->request[$key] = $value;
            }

            $this->validate($this->request, [
                'issue_date' => 'required|date_format:d/m/Y|after_or_equal:01/03/2017|before_or_equal:',
                'project_id' => 'required',
                'provider_id' => 'required|integer|exists:providers,id',
                'voucher_type_id' => 'required|integer|exists:voucher_types,id',
                'invoice_file' => 'required|mimes:jpeg,jpg,png,pdf',
                'payment_type_provider_id' => 'required|integer|exists:payment_type_providers,id',
                'value' => 'required|regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
                'description_id' => 'required',
                'establishment_id' => 'required',
                'original_name' => 'required|string|max:255',
                'voucher_number' => 'required|max:100'
            ]);
            $expense = SupplierExpenses::create($this->getDataToStore());

            
            if(strtoupper($expense->voucherType->name) =='E-MAIL'){
                $expense->update(['voucher_number'=>"EMAIL-{$expense->id}"]);
            } else{
                $expense->update(['voucher_number'=>"{$expense->voucher_number}-{$expense->id}"]);
            }

            event(new SavedSupplierExpense($expense));

            return $this->response->redirectToRoute('supplierExpense.index')
                ->with('success', $this->getMessage('created'));
        } catch (ValidatorException $e) {
            return $this->redirector->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }

    public function edit(int $id)
    {
        $expense = SupplierExpenses::find($id);
        $variablestoview = $this->getVariablesForCreateView();
        $variablestoview['paymentTypes'] = PaymentTypeProviders::where('ative',true)->orWhere('id',$expense->payment_type_provider_id)->get()->pluck('name', 'id');
        $variablestoview['expense'] = $expense;
        $this->authorize('update-supplier-expense', $expense);
        return view('supplier-expenses.edit', ($variablestoview));
    }

    public function update(int $id)
    {
        try {
            $data = $this->getDataToStore();

            foreach ($data as $key => $value) {
                $this->request[$key] = $value;
            }

            $this->validate($this->request, [
                'issue_date' => 'required|date_format:d/m/Y|after_or_equal:01/03/2017|before_or_equal:',
                'project_id' => 'required',
                'provider_id' => 'required|integer|exists:providers,id',
                'voucher_type_id' => 'required|integer|exists:voucher_types,id',
                'invoice_file' => 'mimes:jpeg,jpg,png,pdf',
                'payment_type_provider_id' => 'required|integer|exists:payment_type_providers,id',
                'value' => 'required|regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
                'description_id' => 'required',
                'establishment_id' => 'required',
                'original_name' => 'string|max:255',
                'voucher_number' => 'required|max:100'
            ]);

            $expense = SupplierExpenses::find($id);
            if($expense->project_id != $data['project_id']){
                $data['exported'] = false;
            }
            
            $expense->update($data);

            if(strtoupper($expense->voucherType->name) =='E-MAIL'){
                $expense->update(['voucher_number'=>"EMAIL-{$expense->id}"]);
            }else{
                $expense->update(['voucher_number'=>"{$expense->voucher_number}-{$expense->id}"]);
            }
            if ( $this->isUpload($data) ) {
                event(new SavedSupplierExpense($expense));

            }

            return $this->response->redirectToRoute('supplierExpense.index')
                ->with('success', $this->getMessage('edited'));
        } catch (ValidatorException $e) {
            return $this->redirector->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }

    public function destroy(int $id)
    {
        $expense = SupplierExpenses::findOrFail($id);
        $this->authorize('destroy-supplier-expense', $expense);
        //$this->deleteFileOnDisk($id);
        $expense->forceDelete();
        return $this->response->redirectToRoute('supplierExpense.index')
            ->with('success', $this->getMessage('deleted'));
    }

    public function providers(int $id){
        try{
            $contract = Contracts::whereHas('projects',function($contract){

            })->first();
            if($contract && $contract->providers){
                return $this->response->json(['status' =>false,'providers'=>$contract->providers],200);
            }
            
            return $this->response->json(['status' =>false,'message'=>'not found project'],404);
        } catch(Exception $err){
            if($err instanceof ValidatorException){
                return $this->response->json([
                    'status'=>false,
                    'message'=>$err->getMessageBag()
                ],422);
            }

            return $this->response->json(
                [
                    'status'=>false,
                    'message' =>'error internal server'
                ],500);
        }
    }



    private function getDataToStore(): array
    {
        $data             = $this->request->all();
        $data['exported'] = false;

        if (array_key_exists('invoice_file', $data) && !empty($data['invoice_file'])) {
            $data['original_name'] = $this->getOriginalFilename();
        }

        if (strpos($data['requestable_id'], ' - project') !== false) {
            $data['request_id'] = null;
            $data['project_id'] = explode(' - project', $data['requestable_id'])[0];

            return $data;
        }
        return $data;
    }


    private function getOriginalFilename(): string
    {
        return $this->getUploadedFile('invoice_file')
            ->getClientOriginalName();
    }

    private function getUploadedFile(string $nameOfFile)
    {
        return $this->request->file($nameOfFile);
    }

    private function isUpload(array $data): bool
    {
        return array_key_exists('invoice_file', $data) && !empty($data['invoice_file']);
    }


    private function getDataToRequestableId(Carbon $date)
        {
            if ( \Auth::user()->role_id == self::ROOT_ROLE_ID || $this->hasRequests() ) {
                $requestData = app(RequestRepository::class)
                    ->orderBy('finish', 'asc')
                    ->getPairsByDate($date)
                    ->all();
                $projectData = app(ProjectRepository::class)
                    ->orderBy('finish', 'asc')
                    ->getPairsByDate($date)
                    ->all();

                return $requestData + $projectData;
            }

            return app(ProjectRepository::class)
                ->getPairsByDate($date)
                ->all();
        }

        public function paymentWriteOffs(){
            $extension ='csv';
            $filename = resource_path("views/expenses/LANCAMENTOS_EM_CONTA_CORRENTE.csv");
            $companyId = $this->request['company_id'];
            if($companyId){
                $companyName = app(CompanyRepository::class)->find($companyId)->name;
                 $this->export($this->service->paymentWriteOffs($companyName),$filename,$extension,['D']);
            } else{
                $this->export($this->service->paymentWriteOffs(),$filename,$extension,['D']);
            }
           
            
        }

        public function apportionments(){
            $extension ='csv';
            $filename = resource_path("views/expenses/RATEIOS_LANCAMENTOS_EM_CONTA_CORRENTE.csv");
            $companyId = $this->request['company_id'];
            if($companyId){
                $companyName = app(CompanyRepository::class)->find($companyId)->name;
                 $this->export($this->service->apportionments($companyName),$filename,$extension,['G']);
            } else{
                $this->export($this->service->apportionments(),$filename,$extension,['G']);
            }
        }
}
