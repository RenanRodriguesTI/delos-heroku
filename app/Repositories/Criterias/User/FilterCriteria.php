<?php

namespace Delos\Dgp\Repositories\Criterias\User;

use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCriteria implements CriteriaInterface
{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->with('company', 'role');
        $model = $this->applyFilterUsingWhereNotNullOrNull('deleted_at', $model);

        return $model;
    }
}