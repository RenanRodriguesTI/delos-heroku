<?php

namespace Delos\Dgp\Repositories\Criterias\Request;

use Delos\Dgp\Entities\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ScopeCriteria implements CriteriaInterface
{
    private $authenticatedUser;

    public function apply($model, RepositoryInterface $repository)
    {

        if ($this->haveToAddScope()) {

            $model = $model->where(function ($query) {
                $query->whereHas('project', function ($query) {
                    $query->where('owner_id', $this->getAuthenticatedUser()->id)
                        ->orWhere('co_owner_id', $this->getAuthenticatedUser()->id);
                })->orWhereHas('users', function ($query) {
                    $query->where('user_id', $this->getAuthenticatedUser()->id);
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

    private function haveToAddScope()
    {
        $user = $this->getAuthenticatedUser();

        return !(is_null($user) || $this->hasShowAllRequestsPermission($user));
    }

    private function hasShowAllRequestsPermission(User $user) : bool
    {
        return $user->role
            ->permissions
            ->contains('slug', 'show-all-requests');
    }
}