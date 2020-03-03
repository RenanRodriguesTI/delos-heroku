<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 15/03/17
 * Time: 17:19
 */

namespace Delos\Dgp\Repositories\Criterias\Expense;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCriteria implements CriteriaInterface
{
    use CommonCriteriaTrait;

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->with('user', 'project', 'paymentType');
        $model = $this->applyFilterUsingWhereIn('projects', $model, 'project_id');
        $model = $this->applyFilterUsingWhereIn('users', $model, 'user_id');
        $model = $this->applyFilterUsingWhereNotNullOrNull('deleted_at', $model, 'project');
        $model = $this->applyPeriodFilter($model);
        return $model;
    }

    private function applyPeriodFilter(Builder $model)
    {
        $httpRequest = app('request');
        $period = $httpRequest->input('period');
        if ($period) {
            $arrayDate = explode(' - ', $period);
            $start = Carbon::createFromFormat('d/m/Y', $arrayDate[0])->format('Y-m-d');
            $finish = Carbon::createFromFormat('d/m/Y', $arrayDate[1])->format('Y-m-d');

            $model = $model->whereBetween('issue_date', [$start, $finish]);
        }
        return $model;
    }
}