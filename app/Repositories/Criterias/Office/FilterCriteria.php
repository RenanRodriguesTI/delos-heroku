<?php

namespace Delos\Dgp\Repositories\Criterias\Office;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FilterCriteria.
 *
 * @package namespace Delos\Dgp\Criteria\Repositories\Criterias\Office;
 */
class FilterCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereNull('deleted_at');
        return $model;
    }
}
