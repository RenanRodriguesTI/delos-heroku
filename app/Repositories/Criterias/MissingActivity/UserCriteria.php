<?php

namespace Delos\Dgp\Repositories\Criterias\MissingActivity;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UserCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {

        $users = app('request')->get('users');

        if(is_array($users) && !empty($users)) {
            $model = $model->whereIn('user_id', $users);
        }

        return $model;
    }
}