<?php

namespace Delos\Dgp\Repositories\Criterias\Expense;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LeaderScopeCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where(function($query) {
            $loggedUserId = $this->getAuthenticatedUser()->id;
                $query->whereHas('project', function($query) use ($loggedUserId) {
                    $query->where('owner_id', $loggedUserId);
            });
        });

        $approved = app('request')->input('approved');
        $project = app('request')->input('project');

        if($approved){
            $model = $model->whereIn('approved',$approved);
        } else{
            $model = $model->where('approved',false);
        }

        if($project){
            $model= $model->where('project_id',$project)->orderBy('issue_date','desc');
        }
        return $model;
    }

    private function getAuthenticatedUser()
    {
        return app('auth')->getUser();
    }

}
