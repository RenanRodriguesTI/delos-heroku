<?php

namespace Delos\Dgp\Repositories\Criterias\Project;

use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCriteria implements CriteriaInterface
{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->with('owner', 'activities', 'clients', 'coOwner', 'proposalValueDescriptions');
        $model = $this->applyFilterUsingWhereNotNullOrNull('deleted_at', $model);

        $start = $this->getRequestInput('start');
        $finish = $this->getRequestInput('finish');

        if ($start) {
            $model = $model->whereNull('deleted_at')->where('start', '<=', $start);
        }

        if ($finish) {
            $model = $model->whereNull('deleted_at')->where('finish', '>=', $finish);
        }

        return $model;
    }
}