<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 23/02/18
 * Time: 10:58
 */

namespace Delos\Dgp\Observers;


use Delos\Dgp\Entities\Expense;

class ExpenseObserver
{
    /**
     * Listen to the Expense deleted event
     * @param Expense $expense
     */
    public function deleted(Expense $expense)
    {
        if ($expense->debitMemo && $expense->debitMemo->expenses->count() == 0) {
            $expense->debitMemo()->delete();
        }
    }
}