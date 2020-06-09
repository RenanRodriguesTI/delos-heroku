<?php

    namespace Delos\Dgp\Http\Controllers;

    use Carbon\Carbon;
    use Delos\Dgp\Entities\Expense;
    use Delos\Dgp\Events\SavedExpense;
    use Delos\Dgp\Reports\TxtReportInterface;
    use Delos\Dgp\Repositories\Contracts\CompanyRepository;
    use Delos\Dgp\Repositories\Contracts\FinancialRatingRepository as FrRepository;
    use Delos\Dgp\Repositories\Contracts\PaymentTypeRepository;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Contracts\RequestRepository;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Illuminate\Support\Facades\Storage;
    use Prettus\Validator\Exceptions\ValidatorException;
    use Illuminate\Support\Facades\Auth;

    /**
     * Class ExpensesController
     * @package Delos\Dgp\Http\Controllers
     */
    class ExpensesController extends AbstractController
    {
        /**
         *
         */
        private const ROOT_ROLE_ID = 5;

        /**
         * @return array
         */
        protected function getVariablesForIndexView(): array
        {
            return [
                'companies'                       => app(CompanyRepository::class)->getPairs(),
                'projects'                        => app(ProjectRepository::class)->getPairs(),
                'users'                           => app(UserRepository::class)->getPairs(),
                'frs'                             => app(FrRepository::class)->pluck('cod', 'id'),
                'companiesWithOutPartnerBusiness' => app(CompanyRepository::class)->getPairs(false),
                'companiesDown' =>app(CompanyRepository::class)->findWhereIn('name',['DELOS SERVIÇOS E SISTEMAS','DELOS CONSULTORIA'])->pluck('name','id')

            ];
        }

        /**
         * @return array
         */
        protected function getVariablesForCreateView(): array
        {
            $paymentTypes = $this->translateEntries();

            return [
                'paymentTypes' => $paymentTypes,
            ];
        }

        /**
         * @return array
         */
        protected function getVariablesForEditView(): array
        {
            $users = $this->getUsers();

            $vars = array_merge($this->getVariablesForCreateView(), [
                'users' => $users
            ]);

            return $vars;
        }

        /**
         * @param $id
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function getUsersById($id)
        {
            $userRepo = app(UserRepository::class);

            if ( strpos($id, ' - project') !== false ) {
                $id    = explode(' - project', $id)[0];
                $users = $userRepo->getPairsOfMembersProject($id, 'name', 'id');
                return $this->response->json($users);
            }

            $users = $userRepo->getPairsByRequestId($id);
            return $this->response->json($users);
        }

        /**
         * @param $date
         *
         * @return mixed
         */
        public function getPairsByDate($date)
        {
            $date = Carbon::createFromFormat('Y-m-d', $date);
            return $this->getDataToRequestableId($date);
        }

        /**
         * @return $this|\Illuminate\Http\RedirectResponse
         */
        public function store()
        {
            try {
                $data = $this->getDataToStore();

                $expense = $this->service->create($data);

                $invoice = $expense->invoice . '-' . $expense->id;
                $expense->update(['invoice' => $invoice]);
                event(new SavedExpense($expense));

                return $this->response->redirectTo($this->getInitialUrlIndex())
                                      ->with('success', $this->getMessage('created'));

            } catch ( ValidatorException $e ) {
                return $this->redirector->back()
                                        ->withErrors($e->getMessageBag())
                                        ->withInput();
            }

        }

        /**
         * @param int $id
         *
         * @return $this|\Illuminate\Http\RedirectResponse
         */
        public function update(int $id)
        {
            try {
                $data = $this->getDataToStore();

                $before = $this->repository->find($id);

                if($before->project_id != $data['project_id']){
                    $data['exported'] = false;
                }

                $expense = $this->service->update($data, $id);

                $this->applyChangesUserAndProjectOnDisk($expense, $before);

                if ( $this->isUpload($data) ) {
                    event(new SavedExpense($expense));

                }

                return $this->response->redirectTo($this->getInitialUrlIndex())
                                      ->with('success', $this->getMessage('edited'));

            } catch ( ValidatorException $e ) {
                return $this->redirector->back()
                                        ->withErrors($e->getMessageBag())
                                        ->withInput();
            }
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Auth\Access\AuthorizationException
         */
        public function destroy(int $id)
        {
            $expense = $this->repository->find($id);
            $this->authorize('destroy-expense', $expense);

            $this->deleteFileOnDisk($id);

            $this->service->delete($id);
            return $this->response->redirectTo($this->getInitialUrlIndex())
                                  ->with('success', $this->getMessage('deleted'));
        }

        /**
         * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
         */
        public function reportTxt()
        {
            $companyId = $this->request->input('company_id');
            $expenses  = $this->repository->findWhereUserCompanyId($companyId);

            $report = app(TxtReportInterface::class);
            $report->generate($expenses);

            return $this->response->download(storage_path('app/reports/expenses/expenses.txt'));
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         * @throws \Illuminate\Auth\Access\AuthorizationException
         */
        public function edit(int $id)
        {
            $data = [
                $this->getEntityName() => $this->repository->find($id)
            ];

            $this->authorize('update-expense', $data[$this->getEntityName() ]);
            $variables = $this->getVariablesForEditView();
            $variables['paymentTypes'] = app(PaymentTypeRepository::class)->scopeQuery(function($query) use($data){
                return $query
                ->where('ative',true);
            })->scopeQuery(function($query) use($data){
                return $query->whereNotIn('name',['Cartão Safra'])->orWhere('id',$data[$this->getEntityName()]->payment_type_provider_id);
            })->all()->pluck('name', 'id');

            return $this->response->view("{$this->getViewNamespace()}.edit", array_merge($data, $variables));
        }

        /**
         * @param $id
         */
        private function deleteFileOnDisk($id): void
        {
            $expense = $this->repository->find($id);

            Storage::delete($this->getFullPath($expense) . '/' . $expense->s3_name);
        }

        /**
         * @param Expense $after
         * @param Expense $before
         */
        private function applyChangesUserAndProjectOnDisk(Expense $after, Expense $before): void
        {
            if (!Storage::exists('images/invoices/'.$after->s3_name)&& ( $before->user_id != $after->user_id || $before->request_id != $after->request_id || $before->project_id != $after->project_id )) {
                Storage::move($this->getFullPath($before) . '/' . $before->s3_name, $this->getFullPath($after) . '/' . $after->s3_name);
            }
        }

        /**
         * @param      $expense
         * @param null $id
         *
         * @return string
         */
        private function getFullPath($expense, $id = null): string
        {
            if ( !$id ) {
                $id = $expense->user->id;
            }

            if(Storage::exists('images/invoices/' . $expense->project->company->groupCompany->id . '/' . $expense->project->id . '/' . $id.'/'.$expense->s3_name)){
                return 'images/invoices/' . $expense->project->company->groupCompany->id . '/' . $expense->project->id . '/' . $id;
            }

            return 'images/invoices';
            
        }

           
          

        /**
         * @param array $data
         *
         * @return bool
         */
        private function isUpload(array $data): bool
        {
            return array_key_exists('invoice_file', $data) && !empty($data['invoice_file']);
        }

        /**
         * @return string
         */
        private function getOriginalFilename(): string
        {
            return $this->getUploadedFile('invoice_file')
                        ->getClientOriginalName();
        }

        /**
         * @param string $nameOfFile
         *
         * @return array|\Illuminate\Http\UploadedFile|null
         */
        private function getUploadedFile(string $nameOfFile)
        {
            return $this->request->file($nameOfFile);
        }

        /**
         * @return array
         */
        private function translateEntries()
        {
            $paymentTypes = app(PaymentTypeRepository::class)->findWhereNotIn('name',['Cartão Safra'])->where('ative',true)->pluck('name', 'id');
            $translated   = [];

            foreach ( $paymentTypes as $key => $paymentType ) {
                $translated[$key] = trans("$paymentType");
            }

            return $translated;
        }

        /**
         * @param Carbon $date
         *
         * @return mixed
         */
        private function getDataToRequestableId(Carbon $date)
        {
            if ( \Auth::user()->role_id == self::ROOT_ROLE_ID || $this->hasRequests() ) {
                $requestData = app(RequestRepository::class)
                    ->orderBy('finish', 'asc')
                    ->getPairsByDate($date)
                    ->all();
                $projectData = app(ProjectRepository::class)
                    ->orderBy('finish', 'asc')
                    ->getPairsByFullDescription($date)
                    ->all();

                return $requestData + $projectData;
            }

            return app(ProjectRepository::class)
                ->getPairsByFullDescription($date)
                ->all();
        }

        /**
         * @return array
         */
        private function getDataToStore(): array
        {
            $data             = $this->request->all();
            $data['exported'] = false;

            if ( array_key_exists('invoice_file', $data) && !empty($data['invoice_file']) ) {
                $data['original_name'] = $this->getOriginalFilename();
            }

            if ( strpos($data['requestable_id'], ' - project') !== false ) {
                $data['request_id'] = null;
                $data['project_id'] = explode(' - project', $data['requestable_id'])[0];

                return $data;
            }

            $data['request_id'] = $data['requestable_id'];
            $data['project_id'] = app(RequestRepository::class)->find($data['request_id'])->project->id;

            return $data;
        }

        /**
         * @return \Illuminate\Http\JsonResponse
         */
        private function getUsers()
        {
            $userRepo  = app(UserRepository::class);
            $expenseId = app('router')
                ->current()
                ->parameter('id');
            $expense   = $this->repository->find($expenseId);

            if ( $expense->request_id ) {
                return $userRepo->getPairsByRequestId($expense->request_id);
            }

            return $userRepo->getPairsOfMembersProject($expense->project_id, 'name', 'id')
                            ->all();
        }

        /**
         * @return mixed
         */
        private function hasRequests()
        {
            return \Auth::user()->company->groupCompany->plan->modules()
                                                             ->pluck('name')
                                                             ->contains('Controle de Solicitações para prestação de serviço, tais como Passagem, Hospedagem, Táxi etc.');
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