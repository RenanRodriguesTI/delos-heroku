<?php

    namespace Delos\Dgp\Http\Controllers;

    use Carbon\Carbon;
    use ConsoleTVs\Charts\Facades\Charts;
    use Delos\Dgp\Policies\UserPolicy;
    use Delos\Dgp\Repositories\Contracts\ActivityRepository;
    use Delos\Dgp\Repositories\Contracts\MissingActivityRepository;
    use Delos\Dgp\Repositories\Contracts\RequestRepository;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Delos\Dgp\Repositories\Contracts\AllocationRepository;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Illuminate\Auth\AuthManager;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Delos\Dgp\Entities\Allocation;
    use Calendar;

    class HomeController extends Controller
    {
        private $authManager;

        public function __construct(AuthManager $authManager)
        {
            $this->authManager = $authManager;
        }

        public function index()
        {
            $this->redirectToLoginIfSessionIsNull();
            $user                  = $this->authManager->getUser();
            $projects              = $this->getTotalProjectsIn();
            $activityHours         = $this->getActivitiesHours($user);
            $requestsToApprove     = $this->getRequestsToBeApprove();
            $lastMissingActivities = $this->getLastActivities();
            $chartLine             = $this->getChartLineToActivities();
            $chartPie              = $this->getChartPie();
            $hasExpenses           = $this->HasExpensesToAddGraph();
            $allocations              = $this->TasksCollaborator();

            return view('welcome', compact('projects', 'user', 'activityHours', 'requestsToApprove', 'lastMissingActivities', 'chartLine', 'chartPie', 'hasExpenses', 'allocations'));
        }


        private function getLastActivities(): iterable
        {
            $result = app(MissingActivityRepository::class);

            if ( !app(UserPolicy::class)->isSuperUser($this->authManager->getUser()) ) {
                $result = $result->findWhere(['user_id' => $this->authManager->getUser()->id]);
            }
            else {
                $result = $result->all();
            }

            $result = $result->sortByDesc('date')
                             ->take(8);
            return $result;
        }

        private function getContentToChartLineActivities()
        {
            $result = \DB::table('activities');

            if ( !app(UserPolicy::class)->isSuperUser($this->authManager->getUser()) ) {
                $result = $result->where('user_id', $this->authManager->getUser()->id);
            }

            $result = $result->groupBy(\DB::raw('month(date)'))
                             ->select(\DB::raw('count(*) as total'), \DB::raw('date as date'), 'activities.id');

            $result = $result->join('projects', 'activities.project_id', '=', 'projects.id')
                             ->join('companies', 'projects.company_id', '=', 'companies.id')
                             ->whereIn('companies.id', session('companies'));

            return $result->get();
        }

        private function getContentToChartLineExpenses()
        {
            $result = \DB::table('expenses');

            if ( !app(UserPolicy::class)->isSuperUser($this->authManager->getUser()) ) {
                $result = $result->where('user_id', $this->authManager->getUser()->id);
            }

            $result = $result->groupBy(\DB::raw('month(issue_date)'))
                             ->select(\DB::raw('count(*) as total'), \DB::raw('issue_date as date'));

            $result = $result->join('projects', 'expenses.project_id', '=', 'projects.id')
                             ->join('companies', 'projects.company_id', '=', 'companies.id')
                             ->whereIn('companies.id', session('companies'));

            return $result->get();
        }

        private function getChartLineToActivities()
        {
            $contentToChartLine = $this->getContentToChartLineActivities();

            $chartLine = Charts::multi('areaspline', 'highcharts')
                               ->title(' ')
                               ->colors(['#d69999']);

            $labels   = [];
            $datasets = [];

            foreach ( $contentToChartLine as $item ) {
                $itemDate = Carbon::createFromFormat('Y-m-d', $item->date);
                array_push($labels, trans('months.' . $itemDate->format('F')));
                array_push($datasets, $item->total);
            }

            if ( count($labels) == 0 && count($datasets) == 0 ) {
                $labels   = ['Você não possui atividades lançadas'];
                $datasets = [0];
            }

            $chartLine->labels($labels)
                      ->dataset('Total de atividades', $datasets);
            return $chartLine;
        }

        private function getChartPie()
        {
            $contentToChartLine = $this->getContentToChartLineExpenses();

            $chartLine = Charts::multi('areaspline', 'highcharts')
                               ->title(' ')
                               ->colors(['#d69999']);

            $labels   = [];
            $datasets = [];

            foreach ( $contentToChartLine as $item ) {
                $itemDate = Carbon::createFromFormat('Y-m-d', $item->date);
                array_push($labels, trans('months.' . $itemDate->format('F')));
                array_push($datasets, $item->total);
            }

            if ( count($labels) == 0 && count($datasets) == 0 ) {
                $labels   = ['Você não possui despesas lançadas'];
                $datasets = [0];
            }

            $chartLine->labels($labels)
                      ->dataset('Total de Notas Fiscais por mês', $datasets);
            return $chartLine;
        }

        public function redirectToLoginIfSessionIsNull()
        {
            if ( !session('groupCompanies') ) {
                session()->flush();
                return \Redirect::to('auth/logout')
                                ->send();
            }
        }

        private function HasExpensesToAddGraph(): bool
        {
            $hasExpenses = $this->authManager->getUser()->groupCompany->plan->modules->map(function ($item) {
                        return $item->id;
                    })
                                                                                     ->contains(5) || app(UserPolicy::class)->isRoot($this->authManager->getUser());
            return $hasExpenses;
        }

        private function getActivitiesHours($user)
        {
            $activityHours = app(ActivityRepository::class)->sumApprovedHoursByUserId($user->id);
            return $activityHours;
        }

        private function getRequestsToBeApprove()
        {
            $requestsToApprove = app(RequestRepository::class)
                ->findWhere(['approved' => null])
                ->count();
            return $requestsToApprove;
        }

        private function getTotalProjectsIn(): int
        {
            try {
                $projects = app(UserRepository::class)->find($this->authManager->getUser()->id)->projects->count() ?? 0;
            } catch ( ModelNotFoundException $e ) {
                $projects = 0;
            }
            return $projects;
        }

        private function TasksCollaborator()
        {
            $allocations = app(AllocationRepository::class)
                ->with('project', 'task')
                ->findWhere(['user_id' => $this->authManager->getUser()->id]);

            return $allocations;
        }
    }