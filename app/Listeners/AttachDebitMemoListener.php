<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Jobs\DebitMemoAlertNotify;
use Delos\Dgp\Repositories\Contracts\DebitMemoRepository;
use Delos\Dgp\Repositories\Contracts\ExpenseRepository;

class AttachDebitMemoListener
{
    protected $debitMemos;

    public function __construct(DebitMemoRepository $debitMemos)
    {
        $this->debitMemos = $debitMemos;
    }

    public function handle($event)
    {
        $expense = $event->expense;

        if ($expense->project->financial_rating_id == 1) {
            return false;
        }

        $debitMemo = $this->verifyExistsDebitMemoAttachedProject($expense->project_id);

        if (!$debitMemo) {

            $debitMemo = $this->debitMemos->getAllOpenedAndEmptyRelationships()[0] ?? 0;

            if(!$this->debitMemos->getAllOpenedAndEmptyRelationships()) {
                $number = $this->getNextNumber($expense);

                $debitMemo = $this->debitMemos->create(['finish_at' => null, 'number' => str_pad($number, 4, '0',STR_PAD_LEFT)]);
            }
        }

        $expense->update(['debit_memo_id' => $debitMemo->id]);

        dispatch(new DebitMemoAlertNotify($debitMemo));
    }

    private function verifyExistsDebitMemoAttachedProject(int $id)
    {
        return $this->debitMemos->verifyExistsProjectAttached($id);
    }

    private function getNextNumber($expense) : int
    {
        $companyId = $expense->project->company->id;
        $path = 'project.company';

        return $this->debitMemos->getLastNumberByCompanyType('expenses.'.$path, $companyId) + 1;
    }
}
