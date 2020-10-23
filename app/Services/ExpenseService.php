<?php

    namespace Delos\Dgp\Services;

    use Carbon\Carbon;
    use Delos\Dgp\Repositories\Contracts\ExpenseRepository;
    use Illuminate\Support\Facades\DB;

    class ExpenseService extends AbstractService
    {

        public function repositoryClass(): string
        {
            return ExpenseRepository::class;
        }

        public function create(array $data)
        {
            $data = $this->changeIfIsRetroactive($data);
            $this->changeRulesFromProjectOrRequest($data);

            return parent::create($data);
        }

        public function delete($id)
        {
            return $this->repository->makeModel()->find($id)->forceDelete();
        }

        private function retroactiveNote(array $data): string
        {
            return strlen($data['note']) == 0 ? "Nota retroativa, data original: {$data['issue_date']}" : ", Nota retroativa, data original: {$data['issue_date']}";
        }

        private function changeRulesFromProjectOrRequest(array $data): void
        {
            $rules = $this->validator->getRules();

            if ( $data['request_id'] ) {
                $rules['create']['request_id'] .= '|exists:requests,id';
                $rules['update']['request_id'] .= '|exists:requests,id';

                $this->validator->setRules($rules);

                return;
            }

            $rules['create']['project_id'] .= '|exists:projects,id';
            $rules['update']['project_id'] .= '|exists:projects,id';

            $this->validator->setRules($rules);
        }

        private function changeIfIsRetroactive(array $data): array
        {
            $issueDate = Carbon::createFromFormat('d/m/Y', $data['issue_date']);

            if (!$this->isValidDateToCreateAnExpense($issueDate)) {
                trim($data['note']);
                $data['note'] = $this->retroactiveNote($data);
                $data['issue_date'] = (new Carbon('first day of this month'))->format('d/m/Y');
            }
            return $data;
        }

        private function isValidDateToCreateAnExpense(Carbon $date)
        {
            if (now()->month === $date->month) {
                return true;
            }

            if ($date->isLastMonth()) {
                return now()
                    ->startOfMonth()
                    ->addDays(6)->gte(now());
            }

            return false;
        }

        
        public function paymentWriteOffs($company='DELOS SERVIÇOS E SISTEMAS'){
            $casualties = DB::select('CALL baixas_de_pagamento(?)', [$company]);
            return array_map(function ($value) {

                $value->SINAL = '0';
                $value->VALOR = number_format($value->VALOR,2,'.','');
                return (array)$value;
            }, $casualties);
            
        }

        public function apportionments($company='DELOS SERVIÇOS E SISTEMAS'){
            $apportionments = DB::select('CALL rateios_titulos_a_pagar(?)',[$company]);
            return array_map(function($value){
                $value->VALOR = number_format($value->VALOR,2,',','');
                return (array)$value;
            },$apportionments);
        }

        public function approve(int $id){
            
        }

        public function reprove(int $id){

        }
    }