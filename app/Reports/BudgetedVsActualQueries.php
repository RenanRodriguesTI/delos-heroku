<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19/11/17
 * Time: 23:56
 */

namespace Delos\Dgp\Reports;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use DB;

class BudgetedVsActualQueries
{
    /**
     * Query to getting report of Budgeted vs Actual in hours
     * @return Collection
     */
    public function getBudgetedAndActualHours(): Collection
    {
        /** @var $query Builder */
        $query = DB::table('projects')
            ->join('activities', 'activities.project_id', '=', 'projects.id')
            ->select(
                'projects.compiled_cod as compiled_cod',
                DB::raw("if(`projects`.`deleted_at` is not null, 'Finalizado', 'Em andamento') as status"),
                DB::raw('sum(activities.hours) as actual'),
                'projects.budget as budget',
                DB::raw('projects.budget - sum(hours) as difference'),
                'projects.description as description'
            )->groupBy('projects.id');

        $projects = app('request')->input('projects');

        if (is_array($projects) && !empty($projects)) {
            $query->whereIn('projects.id', $projects);
        }

        $query->whereIn('company_id', session('companies'));

        return $query->get();
    }

    /**
     * Query to getting report of Budgeted vs Actual in values
     * @return Collection
     */
    public function getBudgetedAndActualValues(): Collection
    {
        /** @var $query Builder */
        $query = DB::table('projects')
            ->select(
                'projects.compiled_cod as compiled_cod',
                'projects.id as projects.id',
                DB::raw("if(`projects`.`deleted_at` is not null, 'Finalizado', 'Em andamento') as status"),
                DB::raw('coalesce(`projects_value`.`total_labor`,0) as total_labor'),
                DB::raw("`projects`.`extra_expenses` + coalesce(`projects_expenses`.`value`,0) as `total_expenses`"),
                'projects.extra_expenses as extra_expenses',
                DB::raw('coalesce(`projects_expenses`.`value`,0) as expenses'),
                DB::raw("coalesce(`projects_value`.`total_labor`,0) + `projects`.`extra_expenses` + coalesce(`projects_expenses`.`value`,0) as actual"),
                'projects.proposal_value as budget',
                DB::raw("projects.proposal_value - (coalesce(`projects_value`.`total_labor`,0) + `projects`.`extra_expenses` + coalesce(`projects_expenses`.`value`,0)) as difference"),
                'projects.description as description'
            )
            ->leftJoin('project_user', 'projects.id', '=', 'project_user.project_id')
            ->leftJoin('companies', 'companies.id', '=', 'projects.company_id')
            ->leftJoin('group_companies', 'group_companies.id', '=', 'companies.group_company_id')
            ->leftJoin(DB::raw($this->queryGetProjectsValue()), function (JoinClause $join) {
                $join->on('projects.id', '=', 'projects_value.id');
            })
            ->leftJoin(DB::raw($this->queryGetProjectsExpenses()), function (JoinClause $join) {
                $join->on('projects.id', '=', 'projects_expenses.id');
            })
            ->whereIn('group_companies.id', session('groupCompanies'))
            ->groupBy('projects.id');

        $projects = app('request')->input('projects');

        if (is_array($projects) && !empty($projects)) {
            $query->whereIn('projects.id', $projects);
        }

        return $query->get();
    }
    /**
     * Query to getting report of Months
     * @return Collection
     */
    public function getMonthsReport(): Collection
    {
        /** @var $query Builder */
        $query =  DB::table('projects')
            ->leftJoin('activities', 'projects.id', '=', 'activities.project_id')
            ->leftJoin('users', 'users.id', '=', 'activities.user_id')
            ->leftJoin('companies', 'companies.id', '=', 'projects.company_id')
            ->leftJoin('group_companies', 'group_companies.id', '=', 'companies.group_company_id')
            ->select(
                DB::raw($this->getCaseMonthQuery()),
                DB::raw('YEAR(activities.date) as year'),
                'projects.compiled_cod as compiled_cod',
                'projects.description as description',
                'projects.budget as budget',
                'projects.proposal_value as proposal_value',
                DB::raw('date_format(projects.deleted_at, \'%d/%m/%Y\') as date_deleted'),
                'users.name as name',
                DB::raw('sum(activities.hours) as total_hours'),
                DB::raw('sum(activities.hours)*users.value as total_labor')
            )
            ->whereIn('group_companies.id', session('groupCompanies'))
            ->whereNotNull('activities.date')
            ->groupBy(DB::raw('MONTH(activities.date)'), 'projects.id', 'users.name')
            ->orderBy(DB::raw('MONTH(activities.date)'), 'users.name');

        $query = $this->applyMonthQueryFilters($query);

        return $query->get();
    }

    /**
     * @return mixed
     */
    public function getCollaborators()
    {
        /** @var $query Builder */
        $query = DB::table('users')
            ->select('name', 'value', 'id')
            ->whereIn('group_company_id', session('groupCompanies'))
            ->orderBy('name', 'asc');

        $collaborators = app('request')->input('collaborators');

        if (is_array($collaborators) && !empty($collaborators)) {
            $query->whereIn(DB::raw('users.id'), $collaborators);
        }

        return $query->get();
    }

    /**
     * Query to getting all projects to search filter
     * @return Collection
     */
    public function getProjects(): Collection
    {
        /** @var $query = Builder */
        $query = DB::table('projects')
            ->leftJoin('companies', 'companies.id', '=', 'projects.company_id')
            ->leftJoin('group_companies', 'group_companies.id', '=', 'companies.group_company_id')
            ->select(
                'projects.description',
                'projects.id'
            )
            ->whereIn('group_companies.id', session('groupCompanies'))
            ->get()
            ->pluck('description', 'id');
        return $query;
    }

    /**
     * Convert Collection to array from structure
     * @param array $structure
     * @param $collection
     * @return array
     */
    public function convertToArray(array $structure, Collection $collection): array
    {
        return $collection->transform(function ($item) use ($structure) {
            $result = [];

            foreach ($structure as $name) {
                $result[$name] = is_numeric($item->$name) ? (float) ($item->$name) : $item->$name;
            }


            return $result;
        })->toArray();
    }

    /**
     * Query to getting all years to search filter
     * @return Collection
     */
    public function getYears(): Collection
    {
        /** @var $query = Builder */
        $query = DB::table('projects')
            ->join('activities', 'projects.id', '=', 'activities.project_id')
            ->leftJoin('companies', 'companies.id', '=', 'projects.company_id')
            ->leftJoin('group_companies', 'group_companies.id', '=', 'companies.group_company_id')
            ->select(
                DB::raw('year(activities.date) as date')
            )
            ->whereIn('group_companies.id', session('groupCompanies'))
            ->groupBy(DB::raw('year(activities.date)'))
            ->get()
            ->pluck('date', 'date');

        return $query;
    }

    /**
     * Query to getting all collaborators to search filter
     * @return Collection
     */
    public function getCollaboratorsToSearch(): Collection
    {
        /** @var $query = Builder */
        $query = DB::table('users')
            ->select('id', 'name')
            ->whereIn('group_company_id', session('groupCompanies'))
            ->orderBy('name', 'asc')
            ->get()
            ->pluck('name', 'id');
        return $query;
    }

    /**
     * String of query to determine what month is
     * @return String
     */
    private function getCaseMonthQuery(): string
    {
        return "CASE MONTH(activities.date)
                    WHEN 1 THEN 'JAN'
                    WHEN 2 THEN 'FEV'
                    WHEN 3 THEN 'MAR'
                    WHEN 4 THEN 'ABR'
                    WHEN 5 THEN 'MAI'
                    WHEN 6 THEN 'JUN'
                    WHEN 7 THEN 'JUL'
                    WHEN 8 THEN 'AGO'
                    WHEN 9 THEN 'SET'
                    WHEN 10 THEN 'OUT'
                    WHEN 11 THEN 'NOV'
                    WHEN 12 THEN 'DEZ'
                END AS 'month'";
    }

    /**
     * String of query to getting total labor of the projects
     * @return string
     */
    private function queryGetProjectsValue(): string
    {
        return '(select 
                    p.id as id,
                    sum(a.hours * u.value) as total_labor
                from activities a
                join users u on a.user_id = u.id
                join projects p on p.id = a.project_id
                group by project_id) `projects_value`';
    }

    /**
     * String of query to getting total expenses of the projects
     * @return string
     */
    private function queryGetProjectsExpenses()
    {
        return '(select 
			p.id as id,
				if(p.financial_rating_id = 2, 0, sum(e.value)) as value
			from expenses e
			join projects p on p.id = e.project_id
			group by project_id) `projects_expenses`';
    }

    /**
     * Apply filters received in requests inputs
     * @param $query
     * @return Builder
     */
    private function applyMonthQueryFilters($query) : Builder
    {
        $projects = app('request')->input('projects');

        if (is_array($projects) && !empty($projects)) {
            $query->whereIn('projects.id', $projects);
        }

        $years = app('request')->input('years');

        if (is_array($years) && !empty($years)) {
            $query->whereIn(DB::raw('year(activities.date)'), $years);
        }

        $months = app('request')->input('months');

        if (is_array($months) && !empty($months)) {
            $query->whereIn(DB::raw('month(activities.date)'), $months);
        }

        $collaborators = app('request')->input('collaborators');

        if (is_array($collaborators) && !empty($collaborators)) {
            $query->whereIn(DB::raw('users.id'), $collaborators);
        }

        return $query;
    }
}