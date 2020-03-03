<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 13/06/17
 * Time: 15:37
 */

namespace Delos\Dgp\Repositories\Criterias\Reports\Common;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCriteria implements CriteriaInterface
{

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $this->applyCollaboratorsFilter($model);
        $model = $this->applyMonthsFilter($model);

        return $model;
    }

    private function applyCollaboratorsFilter($model)
    {
        $collaborators = app('request')->input('collaborators');

        if (!empty($collaborators) && is_array($collaborators) && $model->getModel()) {
            $model = $model->whereIn('id', $collaborators);
        }
        return $model;
    }

    private function applyMonthsFilter($model)
    {
        $months = app('request')->input('months');

        if (!empty($months) && is_array($months) && $model->getModel()) {
            $model->whereHas('projects', function ($builder) use ($months) {
                $months = implode(',', $months);
                $builder->onlyTrashed()->whereRaw("month(deleted_at) in({$months})");
            });
        }

        return $model;
    }
}