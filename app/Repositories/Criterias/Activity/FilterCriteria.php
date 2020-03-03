<?php

    namespace Delos\Dgp\Repositories\Criterias\Activity;

    use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;

    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;

    class FilterCriteria implements CriteriaInterface
    {
        use CommonCriteriaTrait;

        public function apply($model, RepositoryInterface $repository)
        {
            $model = $model->with('user', 'place', 'approver', 'task', 'project');
            $model = $this->applyFilterUsingWhereIn('users', $model, 'user_id');
            $model = $this->applyFilterUsingWhereIn('projects', $model, 'project_id');
            $model = $this->applyFilterUsingWhereIn('tasks', $model, 'task_id');
            $model = $this->applyFilterUsingWhereIn('approved', $model);
            $model = $this->applyFilterUsingWhereNotNullOrNull('deleted_at', $model, 'project');
            return $model;
        }
    }