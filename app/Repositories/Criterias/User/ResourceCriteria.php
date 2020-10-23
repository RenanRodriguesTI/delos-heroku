<?php

namespace Delos\Dgp\Repositories\Criterias\User;

use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Carbon\Carbon;
use Exception;

class ResourceCriteria implements CriteriaInterface{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {   
        try{
            $start = Carbon::createFromFormat('d/m/Y',app('request')->input('start'));
            $finish = Carbon::createFromFormat('d/m/Y',app('request')->input('finish'));

     
             return $model->orderBy('name','asc');
        } catch(Exception $err){
            $model = $model->where('id',0);
            return $model;
        }
    }
}