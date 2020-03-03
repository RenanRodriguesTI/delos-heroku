<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 18/04/18
     * Time: 11:05
     */

    namespace Delos\Dgp\Http\Controllers;

    use Carbon\Carbon;
    use Carbon\CarbonInterval;
    use DatePeriod;
    use DateTime;
    use Delos\Dgp\Jobs\GoogleCalendarApi;
    use Delos\Dgp\Repositories\Contracts\ProjectRepository;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Delos\Dgp\Services\ServiceInterface;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Redirector;
    use Illuminate\Routing\ResponseFactory;
    use MaddHatter\LaravelFullcalendar\Calendar;

    /**
     * Class AllocationsController
     * @package Delos\Dgp\Http\Controllers
     */
    class AllocationsController extends AbstractController
    {
        use GoogleCalendarApi;
        protected $withoutPaging = true;
        /**
         * @var Calendar
         */
        private $calendar;

        /**
         * AllocationsController constructor.
         *
         * @param ServiceInterface $service
         * @param ResponseFactory  $response
         * @param Redirector       $redirector
         * @param Request          $request
         * @param Calendar         $calendar
         */
        public function __construct(ServiceInterface $service, ResponseFactory $response, Redirector $redirector, Request $request, Calendar $calendar)
        {
            parent::__construct($service, $response, $redirector, $request);
            $this->calendar = $calendar;
        }

        /**
         * Delete from id and set reason in Allocation
         *
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy(int $id)
        {
            $this->repository->find($id)
                             ->update(['reason' => $this->request->input('reason')]);
            return parent::destroy($id);
        }


        /**
         * Update from id and change hours in Allocation
         *
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         * @return \DatePeriod
         */
        public function updateHours(int $id)
        {
            $allocations = $this->repository->all();

            foreach ( $allocations as $allocation ) {
                $start  = new DateTime($allocation->start->format('Y-m-d'));
                $finish = new DateTime($allocation->finish->format('Y-m-d'));
                $hours  = $allocation->hours;
            }

            $dateRange = new DatePeriod($start, CarbonInterval::days(1), $finish);

            $period = iterator_count($dateRange) * 8;

            $periodAvailable = $period - $hours;

            $hours = $this->request->all();

            foreach ( $hours as $hour ) {
                $horas = $hour;
            }

            \DB::table('allocations')
               ->where('id', '=', $id)
               ->update(['hours' => $horas]);
        }

        /**
         * Update from id and change hours in Allocation
         *
         * @param int $id
         *
         * @return void
         */
        public function updateTasks(int $id)
        {
            $allocations = $this->repository->all();

            $tasks = $this->request->all();

            foreach ( $tasks as $task ) {
                $tasks = $task;
            }

            \DB::table('allocations')
               ->where('id', '=', $id)
               ->update(['task_id' => $tasks]);
        }

        /**
         * Update from id and Status in Allocation
         *
         * @param int $id
         *
         * @return void
         */
        public function updateStatus(int $id)
        {
            $allocations = $this->repository->all();

            $status = $this->request->all();

            foreach ( $status as $allocationStatus ) {
                $status = $allocationStatus;
            }

            \DB::table('allocations')
               ->where('id', '=', $id)
               ->update(['status' => $status]);
        }

        public function gcalendar()
        {
            if ( !session('crentials_token_gcalendar') ) {

                $data = [
                    'authUrl' => $this->getAuthUrl()
                ];

                return $this->response->json($data, 401);
            }

            $events = $this->repository->all();
            $this->insertEvents($events);

            return $this->response->redirectToRoute('allocations.index');
        }

        public function gcalendarCallback()
        {
            session(['crentials_token_gcalendar' => $this->request->input('code')]);

            return $this->response->redirectToRoute('allocations.index')
                                  ->with('logged', 'true');
        }

        public function checkPeriodHours()
        {
            $requestData = $this->request->all();
            $start       = Carbon::createFromFormat('d/m/Y', $requestData['start']);
            $finish      = Carbon::createFromFormat('d/m/Y', $requestData['finish']);
            $possibles   = $this->repository->getPossibleAllocationsFromPeriod($start, $finish, $requestData['user_id'], $requestData);
            $user        = app(UserRepository::class)->find($requestData['user_id']);
            $project     = app(ProjectRepository::class)->find($requestData['project_id']);

            $responseData = [
                'possibles' => $possibles,
                'user'      => $user,
                'project'   => $project
            ];

            return $this->response->json($responseData);
        }

        /**
         * @return array
         */
        protected function getVariablesForCreateView(): array
        {
            $projects = app(ProjectRepository::class)
                ->makeModel()
                ->orderBy('id', 'desc')
                ->where('finish', '>=', Carbon::now())
                ->get()
                ->pluck('full_description', 'id');

            return [
                'projects' => $projects,
            ];
        }

        public function report()
        {
            $data = $this->repository->makeModel()
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
                                             'finish'        => $item->finish->format('d/m/Y'),
                                             'description'   => $item->description,
                                             'compiled_name' => $item->compiled_name,
                                         ];
                                     })
                                     ->all();
        
            $filename = $this->getReportFilename();
            $this->download($data, $filename);
        }
    }
