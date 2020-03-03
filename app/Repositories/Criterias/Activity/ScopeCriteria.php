<?php

namespace Delos\Dgp\Repositories\Criterias\Activity;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ScopeCriteria implements CriteriaInterface
{
    private $authenticatedUser;

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereNotNull('project_id');

        if($this->hasToAddScope()) {
            $model->where(function ($query) {
                $query->where('user_id', $this->getAuthenticatedUser()->id)
                    ->orWhereHas('project', function ($query) {
                        $query->where('owner_id', $this->getAuthenticatedUser()->id)
                            ->orWhere('co_owner_id', $this->getAuthenticatedUser()->id)
                            ->orWhere('client_id', $this->getAuthenticatedUser()->id);
                    });
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
            ->contains('slug', 'show-all-activities');
    }

    private function getAuthenticatedUser()
    {
        if (is_null($this->authenticatedUser)) {
            $this->authenticatedUser = app('auth')->getUser();
        }

        return $this->authenticatedUser;
    }
}