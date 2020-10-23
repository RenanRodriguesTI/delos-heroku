<?php

namespace Delos\Dgp\Repositories\Criterias\Curse;

use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CurseCriteria implements CriteriaInterface
{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        $cursefilter = app('request')->input('curseFilter');

        if ($cursefilter) {

            $model = $model->where('name','like',"%".$cursefilter."%");
        }


        return $model;
    }
}