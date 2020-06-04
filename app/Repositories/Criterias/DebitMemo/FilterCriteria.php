<?php

namespace Delos\Dgp\Repositories\Criterias\DebitMemo;

use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCriteria implements CriteriaInterface
{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        //$model = $model->with('expenses', 'expenses.paymentType', 'expenses.project', 'expenses.user', 'expenses.request', 'expenses.project');
        //$model = $model->with('supplierExpenses', 'supplierExpenses.paymentTypeProvider', 'supplierExpenses.project', 'supplierExpenses.provider');
        $httpRequest = app('request');
        $projectsIds = $httpRequest->input('projects');

        if ($this->isEligibleInput($projectsIds)) {
            $model = $model->whereHas('expenses', function ($query) use ($projectsIds) {
                $query->whereIn('project_id', $projectsIds);
            });  
        }

        $status = $httpRequest->input('status');
        if (is_numeric($status)) {
            switch ($status) {
                case 0:
                    $model = $model->whereNotNull('finish_at');
                    break;
                case 1:
                    $model = $model->whereNull('finish_at');
                    break;
            }
        }
        return $model;
    }

    private function isEligibleInput($input)
    {
        return is_array($input) && !empty($input);
    }
}