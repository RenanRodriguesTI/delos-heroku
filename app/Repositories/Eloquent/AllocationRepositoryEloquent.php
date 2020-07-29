<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 18/04/18
     * Time: 11:45
     */

    namespace Delos\Dgp\Repositories\Eloquent;

    use Delos\Dgp\Entities\Allocation;
    use Delos\Dgp\Presenters\AllocationPresenter;
    use Delos\Dgp\Repositories\Contracts\AllocationRepository;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Criterias\Allocation\FilterCriteria;
    use Delos\Dgp\Repositories\Criterias\Allocation\ScopeCriteria;
    use Delos\Dgp\Services\RangeTrait;
    use Delos\Dgp\Services\WorkingDay;
    use Prettus\Repository\Criteria\RequestCriteria;
    use carbon\Carbon;

    /**
     * Class AllocationRepositoryEloquent
     * @package Delos\Dgp\Repositories\Eloquent
     */
    class AllocationRepositoryEloquent extends BaseRepository implements AllocationRepository
    {
        use RangeTrait, WorkingDay;

        /**
         * @var array
         */
        protected $fieldSearchable = [
            'project.compiled_cod' => 'like',
            'project.description' =>'like',
            'user.name'                => 'like',
            'task.name'                => 'like',
            'hours',
            'description'              => 'like'
        ];

        /**
         * Specify Model class name
         *
         * @return string
         */
        public function model()
        {
            return Allocation::class;
        }

        /**
         * @return string
         */
        public function presenter()
        {
            return AllocationPresenter::class;
        }

        /**
         * @throws \Prettus\Repository\Exceptions\RepositoryException
         */
        public function boot()
        {
            $this->pushCriteria(FilterCriteria::class);
            $this->pushCriteria(ScopeCriteria::class);
            parent::boot();
        }

        /**
         * @param Carbon $start
         * @param Carbon $finish
         * @param int    $userId
         * @param array  $data
         *
         * @return mixed
         */
        public function getPossibleAllocationsFromPeriod(Carbon $start, Carbon $finish, int $userId, array $data)
        {
            $possibles = collect();
            $days      = $this->getDateRange($data['start'], $data['finish']);
            $workDays  = 0;
            $exceptionWorkDays = isset($data['jobWeekEnd']) && $data['jobWeekEnd'] == 'true';

            foreach ( $days as $day ) {
                if ( $this->isWorkingDay($day,$exceptionWorkDays) ) {
                    $hours = $this->findWhere([
                                                  ['start', '>=', $day->format('Y-m-d')],
                                                  ['finish', '<=', $day->format('Y-m-d')],
                                                  'user_id' => $userId,
                                                  ['parent_id','!=',null]
                                              ])
                                  ->sum('hours');
                    $possibles->push([
                                         'date'         => $day->format('d/m/Y'),
                                         'actual_hours' => $hours
                                     ]);
                    $workDays++;
                }
            }

            $possibles = $possibles->map(function ($item) use ($workDays, $data) {
                $item['hours_to_add'] = ($data['hours'] / $workDays);
                return $item;
            });

            return $possibles;

        }


        public function calcToHoursfromPeriod($data){
            $days      = $this->getDateRange($data['start'], $data['finish']);
            $workDays  = 0;
            $hour = $data['hourDay'];
            $hours =0;
            $exceptionWorkDays = isset($data['jobWeekEnd']) && $data['jobWeekEnd'] == 'true';

            foreach ( $days as $day ) {
                if ( $this->isWorkingDay($day,$exceptionWorkDays) ) {
                    $hours+= $hour;
                    $workDays++;
                }
            }

            return  $hours;
        }

        /**
         * @return array
         * @throws \Prettus\Repository\Exceptions\RepositoryException
         */
        public function getAllocationsToReport()
        {
            $allocations = $this->makeModel()
                                ->with('project', 'parent', 'user', 'task')
                                ->whereNull('parent_id')
                                ->orderBy('start', 'desc')
                                ->get()
                                ->map(function ($item) {
                                    return [
                                        'id'            => $item->id,
                                        'project'       => $item->project->full_description,
                                        'user'          => $item->user->name,
                                        'task'          => $item->task->name,
                                        'start'         => $item->start->format('d/m/Y'),
                                        'finish'        => $item->finish->format('d/m/Y]'),
                                        'description'   => $item->description,
                                        'compiled_name' => $item->compiled_name,
                                    ];
                                })
                                ->all();

            return $allocations;
        }
    }