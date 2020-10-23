<?php

namespace Delos\Dgp\Repositories\Criterias\Allocation;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Carbon\Carbon;
use Exception;
/**
 * Class CollaboratorsProjectCriteria.
 *
 * @package namespace Delos\Dgp\Criteria;
 */
class CollaboratorsProjectCriteria implements CriteriaInterface
{

    use CommonCriteriaTrait;
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
        $id = \Auth::user()->id;
        $start = $this->getRequestInput('start');
        $finish = $this->getRequestInput('finish');

        if($start){

            try{
                $start = Carbon::createFromFormat('d/m/Y',$start);
                $model = $model->where('start','>=',$start);
            } catch(Exception $error){

            }
            
        }

        if($finish){
            try{
                $finish = Carbon::createFromFormat('d/m/Y',$finish);
                $model = $model->where('finish','<=',$finish);
            } catch(Exception $error){

            }
        }

        $model = $model->where(function($query) use($id){
            $query->whereHas('project',function($query) use($id){
                $query->where('user_id',$id)
                ->orWhere('owner_id',$id);
            });
        });
        return $model->orderBy('start','desc');
    }
}
