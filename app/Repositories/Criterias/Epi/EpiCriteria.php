<?php

namespace Delos\Dgp\Repositories\Criterias\Epi;

use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class EpiCriteria implements CriteriaInterface
{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        $epifilter = app('request')->input('epiFilter');

        if ($epifilter) {

            $model = $model->where('name','like',"%".$epifilter."%")
            ->orWhere('ca','like',"%".$epifilter."%");
        }


        return $model->whereNull('deleted_at');
    }
}
