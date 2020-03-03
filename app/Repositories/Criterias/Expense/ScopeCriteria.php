<?php

namespace Delos\Dgp\Repositories\Criterias\Expense;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ScopeCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {

        if ($this->hasToAddScope()) {
            $model = $model->where(function($query) {
                $loggedUserId = $this->getAuthenticatedUser()->id;
                    $query->whereHas('project', function($query) use ($loggedUserId) {
                        $query->where('owner_id', $loggedUserId)
                            ->orWhere('co_owner_id', $loggedUserId);
                })->orWhere('user_id', $loggedUserId);
            });
        }

        return $model;
    }

    private function hasToAddScope() : bool
    {
        if (is_null($user = $this->getAuthenticatedUser())) {
            return false;
        }

        return !$user->role
            ->permissions
            ->contains('slug', 'show-all-expenses');
    }

    private function getAuthenticatedUser()
    {
        return app('auth')->getUser();
    }
}