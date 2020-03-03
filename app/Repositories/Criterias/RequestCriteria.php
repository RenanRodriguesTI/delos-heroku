<?php

namespace Delos\Dgp\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class RequestCriteria implements CriteriaInterface
{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('parent_id', null);
        $model= $model->with('project', 'requester', 'users', 'children', 'children.tickets', 'children.car', 'children.lodging', 'children.extraExpenses');
        $model = $this->applyFilterUsingWhereNotNullOrNull('deleted_at', $model, 'project');
        $model = $this->applyFilterUsingWhereNotNullOrNull('approved', $model);
        return $model;
    }

}