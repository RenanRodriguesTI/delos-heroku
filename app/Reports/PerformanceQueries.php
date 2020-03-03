<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 22/06/17
     * Time: 17:44
     */

    namespace Delos\Dgp\Reports;

    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\DB;

    /**
     * Class PerformanceQueries
     * @package Delos\Dgp\Reports
     */
    class PerformanceQueries
    {
        /**
         * @return mixed
         */
        public function getOwnersReport()
        {
            $data  = collect();
            $users = $this->getUsers();

            $users->each(function ($item) use ($data) {
                $projects    = $this->getProjects($item);
                $hoursSummed = $this->getSummedHours($projects);

                $data->push([
                                'name'     => $item->name,
                                'total'    => $projects->count(),
                                'budgeted' => $projects->sum('budget'),
                                'expend'   => $hoursSummed,
                                'projects' => $projects
                            ]);
            });


            return $data;
        }

        /**
         * @return mixed
         */
        public function getUsersReport()
        {
            $query = DB::table('users')
                       ->select('users.name', DB::raw('COUNT(projects.id) AS `total_projects`'), DB::raw('SUM(IF(projects.budget >= projects.hours_expended, 1, 0)) AS `total_right_projects`'), DB::raw('SUM(IF(projects.budget < projects.hours_expended, 1, 0)) AS `total_wrong_projects`'))
                       ->join('project_user', 'users.id', '=', 'project_user.user_id')
                       ->rightJoin(DB::raw("({$this->getQueryToUsersReport()}) as projects"), 'projects.id', '=', 'project_user.project_id')
                       ->whereNull('users.deleted_at')
                       ->whereNotNull('users.name')
                       ->groupBy('users.name');

            $query = $this->applyWhereInCollaboratorsGotInQueryString($query);

            return $query->get();
        }

        /**
         * @return string
         */
        private function getQueryToUsersReport(): string
        {
            $query = "SELECT projects.id AS `id`, projects.budget AS `budget`, SUM(COALESCE(activities.hours,0)) AS `hours_expended` FROM activities RIGHT JOIN projects ON activities.project_id = projects.id WHERE projects.deleted_at IS NOT NULL AND projects.company_id IN ({$this->getCompanies()})";

            $query = $this->addWhereMonthsIfExists([$query])[0];
            $query = $this->addWhereYearsIfExists([$query])[0];
            $query .= "  GROUP BY projects.id";
            return $query;
        }

        /**
         * @param $query
         *
         * @return mixed
         */
        private function applyWhereInCollaboratorsGotInQueryString($query)
        {
            $collaborators = app('request')->input('collaborators');

            if ( is_array($collaborators) && !empty($collaborators) ) {
                $query = $query->whereIn('users.name', $collaborators);
            }

            return $query;
        }

        /**
         * @param array $queries
         *
         * @return array
         */
        private function addWhereMonthsIfExists(array $queries): array
        {
            $months = app('request')->input('months');

            if ( is_array($months) && !empty($months) ) {
                $months = implode(',', $months);
                foreach ( $queries as $key => $query ) {
                    $queries[$key] = "{$query} AND MONTH(projects.deleted_at) in ({$months})";
                }
            }

            return $queries;
        }

        /**
         * @param array $queries
         *
         * @return array
         */
        private function addWhereYearsIfExists(array $queries): array
        {
            $years = app('request')->input('years');

            if ( is_array($years) && !empty($years) ) {
                $years = implode(',', $years);
                foreach ( $queries as $key => $query ) {
                    $queries[$key] = "{$query} AND YEAR(projects.deleted_at) in ({$years})";
                }
            }

            return $queries;
        }

        /**
         * @return string
         */
        private function getCompanies(): string
        {
            return implode(',', session('companies'));
        }

        /**
         * @param $user
         *
         * @return mixed
         */
        private function getProjects($user)
        {
            $months   = app('request')->input('months');
            $years    = app('request')->input('years');
            $projects = $user->owningProjects;

            if ( is_array($years) && !empty($years) ) {
                $projects = $projects->filter(function ($project) use ($years, $projects) {
                    return in_array($project->deleted_at->year, $years);
                });
            }

            if ( is_array($months) && !empty($months) ) {
                $projects = $projects->filter(function ($project) use ($months, $projects) {
                    return in_array($project->deleted_at->month, $months);
                });
            }
            return $projects;
        }

        /**
         * @return mixed
         */
        private function getUsers()
        {
            $usersRequest = app('request')->input('collaborators');
            $userRepo     = app(UserRepository::class);
            $users        = $userRepo->with('owningProjects', 'owningProjects.activitiesWithTrashed')
                                     ->orderBy('name', 'asc')
                                     ->whereHas('owningProjects', function (Builder $query) {
                                         $query->whereNotNull('deleted_at');
                                     });
            if ( is_array($usersRequest) && !empty($usersRequest) ) {
                $users = $users->makeModel()
                               ->whereIn('id', $usersRequest);
            }
            return $users->get();
        }

        /**
         * @param $projects
         *
         * @return int
         */
        private function getSummedHours($projects): int
        {
            $hoursSummed = 0;
            foreach ( $projects as $project ) {
                $hoursSummed += $project->getSpentHours();
            }
            return $hoursSummed;
        }
    }