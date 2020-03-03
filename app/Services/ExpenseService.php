<?php

    namespace Delos\Dgp\Services;

    use Carbon\Carbon;
    use Delos\Dgp\Repositories\Contracts\ExpenseRepository;

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
    }