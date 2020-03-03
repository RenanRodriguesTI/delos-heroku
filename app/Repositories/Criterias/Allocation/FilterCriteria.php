<?php
    namespace Delos\Dgp\Repositories\Criterias\Allocation;

    use Delos\Dgp\Repositories\Criterias\CommonCriteriaTrait;
    use Prettus\Repository\Contracts\CriteriaInterface;
    use Prettus\Repository\Contracts\RepositoryInterface;
    use Carbon\Carbon;
    use DB;

    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 03/05/18
     * Time: 16:05
     */

    class FilterCriteria implements CriteriaInterface
    {
        use CommonCriteriaTrait;
        /**
         * Apply criteria in query repository
         *
         * @param                                                   $model
         * @param RepositoryInterface $repository
         *
         * @return mixed
         */
        public function apply($model, RepositoryInterface $repository)
        {
            $model = $model->with('project', 'parent', 'user', 'task');
            $model = $this->applyFilterUsingWhereNotNullOrNull('deleted_at', $model);
            return $model;
        }
    }