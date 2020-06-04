<?php

namespace Delos\Dgp\Repositories\Criterias\Project;

use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FilterCriteria implements CriteriaInterface
{
    private const ROOT_ROLE_ID = 5;

    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->with('owner', 'activities', 'clients', 'coOwner', 'proposalValueDescriptions');
        $model = $this->applyFilterUsingWhereNotNullOrNull('deleted_at', $model);

        $start = $this->getRequestInput('start');
        $finish = $this->getRequestInput('finish');
        $requests = $this->getRequestInput('requests');
        $showall = $this->getRequestInput('showall');

        if ($start) {
            $model = $model->whereNull('deleted_at')->where('start', '<=', $start);
        }

        if ($finish) {
            $model = $model->whereNull('deleted_at')->where('finish', '>=', $finish);
        }

        switch($showall){
            case 'false':
                $model = $model->whereHas('allocations',function($query) use($start,$finish){

                    $query->where('user_id',Auth::user()->id)->where('start','<=', $start)->where('finish','>=',$finish)->whereHas('project',function($query) use($finish){
                        $query->orWhere('extension','>=',$finish);
                    });
                    
                    if(\Auth::user()->role_id != self::ROOT_ROLE_ID){
                         
                    }
                });
            break;

            default:
                $model = $model->orWhere('extension','>=',$finish);
            break;
        }

        if($requests){
            //$model = $model->orWhere('extension','>=',$finish);
        }

        

     

        return $model;
    }
}