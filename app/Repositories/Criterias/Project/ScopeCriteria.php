<?php

namespace Delos\Dgp\Repositories\Criterias\Project;

use Delos\Dgp\Entities\User;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ScopeCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        if(true === $this->haveToAddScope()) {

            $userId = $this->getAuthenticatedUser()->id;
            $model->where(function ($query) use ($userId) {
                $query->whereHas('members', function ($query) use ($userId) {
                    $query->where('id', $userId);
                })->orWhere('seller_id', $userId);
            });
        }

        return $model;
    }

    private function haveToAddScope() : bool
    {
        if (is_null($user = $this->getAuthenticatedUser())) {
            return false;
        }

        return !$user->role
            ->permissions
            ->contains('slug', 'show-all-projects');
    }

    private function getAuthenticatedUser() : ?User
    {
        return app('auth')->getUser();
    }
}