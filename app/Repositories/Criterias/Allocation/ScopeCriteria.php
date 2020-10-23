<?php

namespace Delos\Dgp\Repositories\Criterias\Allocation;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ScopeCriteria implements CriteriaInterface
{
    private $authenticatedUser;

    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->hasToAddScope()) {
            $model = $model->where(function ($query) {
                $query->whereHas('project', function ($query) {
                    // $query->where('owner_id', $this->getAuthenticatedUser()->id)
                    //     ->orWhere('co_owner_id', $this->getAuthenticatedUser()->id)
                    //     ->orWhere('user_id', $this->getAuthenticatedUser()->id);
                    $query->where('user_id',$this->getAuthenticatedUser()->id);
                });
            });
        }

        return $model;
    }

    private function getAuthenticatedUser()
    {
        if (is_null($this->authenticatedUser)) {
            $this->authenticatedUser = app('auth')->getUser();
        }

        return $this->authenticatedUser;
    }

    private function hasToAddScope(): bool
    {
        if (is_null($user = $this->getAuthenticatedUser())) {
            return false;
        }

        return !$user->role
            ->permissions
            ->contains('slug', 'show-all-expenses');
    }
}
