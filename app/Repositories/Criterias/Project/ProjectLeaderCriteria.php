<?php

namespace Delos\Dgp\Repositories\Criterias\Project;

use Delos\Dgp\Policies\UserPolicy;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProjectLeaderCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $user = app('auth')->getUser();

        if(is_null($user) || (new UserPolicy())->isSuperUser($user)) {
            return $model;
        }

        $model = $model->where(function($query) use($user){
            $query->where('owner_id', $user->id)
                ->orWhere('co_owner_id', $user->id);
        });

        return $model;
    }

}