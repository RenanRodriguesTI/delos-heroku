<?php

namespace Delos\Dgp\Policies;

use Delos\Dgp\Entities\Expense;
use Delos\Dgp\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    public function updateExpense(User $user, Expense $expense) : bool
    {

        if ($this->hasPermission($user, 'update-expense-after-export')) {
            return true;
        }

        if (false === $expense->exported && $this->hasPermission($user, 'update-expense')) {
            return true;
        }

        return false;
    }

    public function destroyExpense(User $user, Expense $expense) : bool
    {

        if (true === $expense->exported) {
            return false;
        }

        return $this->hasPermission($user, 'destroy-expense');

    }

    private function hasPermission(User $user, string $slug)
    {

        return $user->role
            ->permissions
            ->contains('slug', $slug);
    }

    public function managerApprove(User $user,Expense $expense){
        
        return $this->isLeaderProject($user,$expense);
    }

    public function managerReprove(User $user, Expense $expense){
        return $this->isLeaderProject($user,$expense);
    }   

    public function isLeaderProject(User $user,Expense $expense){
        

        return $expense->project->owner_id === $user->id;
    }
}
