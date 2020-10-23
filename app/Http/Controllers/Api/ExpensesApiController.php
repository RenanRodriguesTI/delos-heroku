<?php

namespace Delos\Dgp\Http\Controllers\Api;
use Delos\Dgp\Entities\Expense;
use Delos\Dgp\Entities\PaymentType;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\Allocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Delos\Dgp\Events\SavedExpense;
use Prettus\Validator\Exceptions\ValidatorException;
use Delos\Dgp\Repositories\Contracts\CompanyRepository;
use Delos\Dgp\Repositories\Contracts\RequestRepository;
use Intervention\Image\ImageManagerStatic as Image;
use Exception;

class ExpensesApiController extends AbstractController
{
    public function store()
    {
        try {

            

            $data = $this->getDataToStore();
            $this->request->validate([
                "issue_date"=>'required|date_format:"d/m/Y"'
            ]);
            
           // $data["issue_date"] = \Carbon\Carbon::parse($data["issue_date"])->format('d/m/Y');

            $expense = $this->service->create($data);
            $invoice = $expense->invoice . '-' . $expense->id;
            $expense->update(['invoice' => $invoice]);
	    $project = $expense->project;   
  	    $allocations = Allocation::where('user_id',$expense->user_id)
            ->where('project_id',$project->id)
            ->where('finish','>=',$expense->issue_date)
            ->get();

            $approved = true;

            if($allocations->isEmpty() || !$expense->request_id){
                $approved = false;
            }
          
            
            event(new SavedExpense($expense));
            $expense = Expense::find($expense->id);       
              $expense->update([
                'link' => $expense->url_file,
                'approved'=>$approved
            ]);

            
            
            $allocations = Allocation::where('user_id',$expense->user_id)
            ->where('project_id',$project->id)
            ->where('finish','>=',$expense->issue_date)
            ->get();

            $approved = true;

            if($allocations->isEmpty() || !$expense->request_id){
                $approved = false;
            }

            $expense->update([
                'link' => $expense->url_file,
                'approved'=>$approved
            ]);

            return $this->response->json([
                'status' => true,
                'message'=>"created",
            ]);
        } catch ( ValidatorException $e ) {
            return $this->response->json([
                    'status' => false,
                    'errors' => $e->getMessageBag()
            ], 400);
        }
    }

    private function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 
    
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
    
        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    
        // clean up the file resource
        fclose( $ifp ); 
    
        return $output_file; 
    }



    public function showdescription(Request $request){
        try{
            $description = $request["description"];

            $descriptions = DB::select('SELECT description FROM expenses where description like :description group by description ', ["description"=>"%".$description."%"]);

            if($descriptions !=null && sizeof($descriptions)>0){
                return $this->response->json([
                    "found"=>true,
                    "descriptions"=>$descriptions
                ],200);
            }
            else
                return $this->response->json([
                    "found"=>false,
                    "message"=>"Record not found"
                ],404);
        }
        catch(Exception $erro){
            return $this->response->json([
                "found"=>false,
                "message"=>$erro->getMessage()
            ],400);
        }
    }

    public function showall($iduser){
        try{
                
        if(!is_numeric($iduser)){
            return $this->response->json([
                "erro"=>"Iduser is numeric"
            ],400);
        }  
          $expenses =  DB::select("SELECT e.id,e.invoice,e.issue_date,e.value,e.payment_type_id,e.description,e.note,e.user_id,e.request_id,e.deleted_at,e.created_at,e.updated_at,invoice_file,e.original_name,e.s3_name,e.exported,e.debit_memo_id,e.project_id,p.compiled_cod,link FROM expenses e inner join projects p on e.project_id = p.id  where user_id = :id and e.deleted_at is null",["id"=>$iduser]);



            if($expenses!=null && sizeof($expenses)){
               $expenses = collect($expenses)->map(function($item){
                    $item->link =  $this->getLink($item->s3_name);
                    return $item;
                });
                return $this->response->json([
                    "found"=>true,
                    "expenses"=>$expenses
                ],200);
            }
            else
            return $this->response->json([
                "found"=>false,
                "message"=>"Record not found"
            ],404);
        }
        catch(Exception $erro){
            return $this->response->json([
                "found"=>false,
                "message"=>$erro->getMessage()
            ],400);
        }
    }

    public function getLink($s3_name){
        return  Storage::url('images/invoices/'.$s3_name);
    }

    public function show($id) {
        if(!is_numeric($id)) {
            return $this->response->json([
                'found' => false,
                'message'   => 'Enter a numeric id.'
            ], 400);
        }

        $expense = Expense::find($id);
        if(!$expense) {
            return $this->response->json([
                'found' => false,
                'message'   => 'Record not found'
            ], 404);
        }

        return $this->response->json([
            'found' => true,
            'expense' => $expense,
        ]);
    }

    public function update($id){
        if(!is_numeric($id)) {
            return $this->response->json([
                'status' => false,
                'message'   => 'Enter a numeric id.'
            ], 400);
        }

        try {
           
            $data = $this->getDataToStore();
            // $data["issue_date"] = \Carbon\Carbon::parse($data["issue_date"])->format('d/m/Y');
            $before = Expense::find($id);
            if(!$before) {
                return $this->response->json([
                    'status' => false,
                    'message'   => 'Record not found'
                ], 404);
            }

            $expense = $this->service->update($data, $id);

            $invoice = $expense->invoice . '-' . $expense->id;
            $expense->update(['invoice' => $invoice]);

            $this->applyChangesUserAndProjectOnDisk($expense, $before);

            if ( $this->isUpload($data) ) {
                event(new SavedExpense($expense));
            }

            return $this->response->json([
                'status' => true,
                'companny' => $expense->project->company->groupCompany->id
            ]);
        } catch ( ValidatorException $e ) {
            return $this->response->json([
                'status' => false,
                'errors' => $e->getMessageBag()
            ], 400);
        }
    }

    public function delete($id){
        if(!is_numeric($id)) {
            return $this->response->json([
                'status' => false,
                'message'   => 'Enter a numeric id.'
            ], 400);
        }

        

        $expense = Expense::find($id);
        if(!$expense) {
            return $this->response->json([
                'status' => false,
                'message'   => 'Record not found'
            ], 404);
        }

        $this->deleteFileOnDisk($id);

        $this->service->delete($id);

        return $this->response->json([
            'status' => true
        ]);
    }

    private function deleteFileOnDisk($id): void
    {
        $expense = Expense::find($id);

        Storage::delete('images/invoices/' . $expense->s3_name);
    }


    private function getFullPath($expense, $id = null): string
    {
        if ( !$id ) {
            $id = $expense->user->id;
        }
      

        return 'images/invoices/' . $expense->project->company->groupCompany->id . '/' . $expense->project->id . '/' . $id;
    }

    /**
     * @return array
     */
    private function getDataToStore(): array
    {
        $data             = $this->request->all();
        $data['exported'] = false;

        if ( array_key_exists('invoice_file', $data) && !empty($data['invoice_file']) ) {
            $data['original_name'] = "ImagemProject.jpeg";
        }

        if ( isset($data['requestable_id']) && strpos($data['requestable_id'], ' - project') !== false ) {
            $data['request_id'] = null;
            $data['project_id'] = explode(' - project', $data['requestable_id'])[0];
            return $data;
        }

        
        $data['request_id'] = $data['request_id'] ?? null;
        //$data['project_id'] = app(RequestRepository::class)->find($data['request_id'])->project->id;

        return $data;
    }

    /**
     * @param Expense $after
     * @param Expense $before
     */
    private function applyChangesUserAndProjectOnDisk(Expense $after, Expense $before): void
    {
        if ( ($before->user_id != $after->user_id || $before->request_id != $after->request_id || $before->project_id != $after->project_id) && $after->id <= 14178 ) {
            Storage::move($this->getFullPath($before) . '/' . $before->s3_name, $this->getFullPath($after) . '/' . $after->s3_name);
        }
    }

    private function isUpload(array $data): bool
    {
        return array_key_exists('invoice_file', $data) && !empty($data['invoice_file']);
    }
}
