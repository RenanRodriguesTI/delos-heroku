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
use Delos\Dgp\Repositories\Contracts\TaskRepository;
use Delos\Dgp\Repositories\Contracts\AllocationRepository;
use Delos\Dgp\Repositories\Criterias\Allocation\CollaboratorsProjectCriteria;
use Delos\Dgp\Repositories\Criterias\Allocation\ScopeCriteria;
use Delos\Dgp\Services\ServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;
use MaddHatter\LaravelFullcalendar\Calendar;
use Prettus\Validator\Exceptions\ValidatorException;
use Delos\Dgp\Rules\TaskHoursRule;
use Exception;

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


    public function index()
    {

        if ($this->isFileDownload()) {
            $data     = $this->getDataForListingWithoutPaging();
            $filename = $this->getReportFilename();
            $this->download($data['data'], $filename);
        }

        if ($this->request->wantsJson()) {
            $data = $this->getDataForListingWithoutPaging();
            return $this->response->json($data);
        }

        $this->guardUrlIndex();

        $data = [
            'allocations' => $this->repository->getChildrenForDateRange()
        ];
        $data = array_merge($data, $this->getVariablesForIndexView());

        return view('allocations.index', $data);
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


    public function store()
    {
        try {
            $allocations = $this->service->create($this->getRequestDataForStoring());
            if ($this->request->wantsJson()) {
                return $this->response
                    ->json(
                        [
                            'allocations' => $allocations,
                            'father' => $allocations->first()->parent_id
                        ],
                        201
                    );
            }

            if (isset($this->request['addTasks'])) {
                return $this->response->redirectToRoute('allocations.addTasks', ['id' => $allocations[0]->parent_id]);
            }
            return $this->response->redirectTo($this->getInitialUrlIndex())->with('success', $this->getMessage('created'));
        } catch (ValidatorException $e) {
            if ($this->request->wantsJson()) {
                return $this->response->json($e->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function update(int $id)
    {
        try {
            $allocations = $this->service->update($this->request->all(), $id);

            if ($this->request->wantsJson()) {
                return $this->response->json(['allocations' => $allocations], 200);
            }

            if (isset($this->request['addTasks'])) {
                return $this->response->redirectToRoute('allocations.addTasks', ['id' => $allocations[0]->parent_id]);
            }
            return $this->response->redirectTo($this->getInitialUrlIndex())->with('success', $this->getMessage('edited'));
        } catch (ValidatorException $e) {
            if ($this->request->wantsJson()) {
                return $this->response->json($e->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function edit(int $id)
    {
        $data = [
            'allocation' => $this->repository->find($id)
        ];

        if ($data['allocation']) {
            $projects = app(ProjectRepository::class)
                ->makeModel()
                ->orderBy('id', 'desc')
                ->where('id', '=', $data['allocation']->project->id)
                ->orWhere('finish', '>=', Carbon::now())
                ->orWhere('extension', '>=', Carbon::now())
                ->get()
                ->pluck('full_description', 'id');
        } else {
            $projects = app(ProjectRepository::class)
                ->makeModel()
                ->orderBy('id', 'desc')
                ->orWhere('finish', '>=', Carbon::now())
                ->orWhere('extension', '>=', Carbon::now())
                ->get()
                ->pluck('full_description', 'id');
        }



        $variables = [
            'projects' => $projects,
            'userException' => app('auth')->getUser()->name === "ANA CAROLINA CALVETI" || app('auth')->getUser()->name === "VERONICA SALVATI",
            'group_company_id' => \Auth::user()->groupCompany->id
        ];


        return $this->response->view("allocations.edit", array_merge($data, $variables));
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

        foreach ($allocations as $allocation) {
            $start  = new DateTime($allocation->start->format('Y-m-d'));
            $finish = new DateTime($allocation->finish->format('Y-m-d'));
            $hours  = $allocation->hours;
        }

        $dateRange = new DatePeriod($start, CarbonInterval::days(1), $finish);

        $period = iterator_count($dateRange) * 8;

        $periodAvailable = $period - $hours;

        $hours = $this->request->all();

        foreach ($hours as $hour) {
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

        foreach ($tasks as $task) {
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

        foreach ($status as $allocationStatus) {
            $status = $allocationStatus;
        }

        \DB::table('allocations')
            ->where('id', '=', $id)
            ->update(['status' => $status]);
    }

    public function gcalendar()
    {
        if (!session('crentials_token_gcalendar')) {

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

        if ($project) {
            $project->full_description = $project->full_description;
        }

        $responseData = [
            'possibles' => $possibles,
            'user'      => $user,
            'project'   => $project
        ];

        return $this->response->json($responseData);
    }

    public function calcHoursPeriod()
    {
        $hours = $this->repository->calcToHoursfromPeriod($this->request->all());
        return $this->response->json([
            'hours' => $hours
        ], 200);
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
            ->orWhere('extension', '>=', Carbon::now())
            ->get()
            ->pluck('full_description', 'id');

        return [
            'projects' => $projects,
            'userException' => app('auth')->getUser()->name === "ANA CAROLINA CALVETI" || app('auth')->getUser()->name === "VERONICA SALVATI"
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

    public function checkHours($id)
    {
        $hours = $this->request['hours'] ?? 0;

        $check =  $this->service->checkHours($hours, $id);

        return $this->response->json([
            'check' => $check
        ], 200);
    }

    public function addTasksIndex(int $id)
    {
        $this->changeCriteria();
        $allocation = $this->repository->with('allocationTasks', 'allocationTasks.task')->find($id);

        if ($this->request->wantsJson()) {
            return $this->response->json([
                'allocationTasks' => $allocation->allocationTasks->map(function ($item) {
                    $item->task;
                    return $item;
                }),
                'allocation' => $allocation
            ], $allocation->allocationTasks->isEmpty() ? 404 : 200);
        }
        $allocationTasks = $allocation->allocationTasks()->paginate(15);
        $tasks = $allocation->project->tasks->pluck('name', 'id');
        return view('allocations.tasks.add_task', compact('allocation', 'tasks', 'allocationTasks'));
    }

    public function addTaskStore(int $id)
    {
        $this->changeCriteria();

        $allocation = $this->repository->find($id);
        $validator = \Validator::make($this->request->all(), [
            'task_id' => 'required|exists:tasks,id',
            'hours' => ['bail', 'required', 'numeric', 'min:1', 'integer', new TaskHoursRule($id)],
            'start' => 'date_format:d/m/Y|after_or_equal:' . $allocation->start->format('d/m/Y') . '|before_or_equal:' . $allocation->finish->format('d/m/Y'),
            'finish' => 'date_format:d/m/Y|before_or_equal:' . $allocation->finish->format('d/m/Y') . '|after_or_equal:' . $allocation->start->format('d/m/Y')
        ]);



        if ($validator->fails()) {

            if ($this->request->wantsJson()) {
                return $this->response->json($validator->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($validator->getMessageBag())->withInput();
        }

        $allocationTasks = $this->service->createTask($this->request->all(), $id);

        if ($this->request->wantsJson()) {
            return $this->response->json([
                'allocation' => $allocationTasks[0]->allocation,
            ], 201);
        }
        return $this->response->redirectToRoute('allocations.addTasks', ['id' => $id]);
    }

    public function updateTask(int $id, int $allocationTaskId)
    {
        $this->changeCriteria();
        $validator = \Validator::make($this->request->all(), [
            'task_id' => 'required|exists:tasks,id',
            'hours' => ['bail', 'required', 'numeric', 'min:1', 'integer', new TaskHoursRule($id, $allocationTaskId, true)],
            'start' => 'date_format:d/m/Y|after_or_equal:' . $allocation->start->format('d/m/Y') . '|before_or_equal:' . $allocation->finish->format('d/m/Y'),
            'finish' => 'date_format:d/m/Y|before_or_equal:' . $allocation->finish->format('d/m/Y') . '|after_or_equal:' . $allocation->start->format('d/m/Y')
        ]);

        if ($validator->fails()) {
            if ($this->request->wantsJson()) {
                return $this->response->json($validator->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($validator->getMessageBag())->withInput();
        }

        $allocationTasks = $this->service->updateTask($this->request->all(), $id, $allocationTaskId);

        if ($this->request->wantsJson()) {
            return $this->response->json([
                'allocation' => $allocationTasks[0]->allocation,
            ], 201);
        }

      
        return $this->response->redirectToRoute('allocations.addTasks', ['id' => $id]);
    }

    public function destroyTask($id, $allocationTaskId)
    {
        $this->service->deleteTask($id, $allocationTaskId);
        return $this->response->redirectToRoute('allocations.addTasks', ['id' => $id]);
    }

    public function checkHoursTask(int $id){
            $validator = \Validator::make($this->request->all(),[
                'start' =>'date_format:d/m/Y',
                'finish' =>'date_format:d/m/Y',
                'hours' =>'required|numeric|min:0'
            ]);


            if ($validator->fails()) {
                if ($this->request->wantsJson()) {
                    return $this->response->json($validator->getMessageBag(), 422);
                }
            }

            $message ='';

            switch($this->service->checkHoursTask($this->request->all())){
                case -1 :
                    $message = 'Atenção foi ultrapassado as 8 horas diárias';
                break;
                case 1 :
                    $message = 'Atenção recurso disponível em outros projetos';
                break;
                default:
                 $message ='';  
            }

            
          return $this->response->json([
              'checkHours' =>$message
          ],200);
    }

    public function manager()
    {
        $this->changeCriteria();

        $tasks = [];

        $projects = app(ProjectRepository::class);

        $start = $this->request->input('start');
        $finish = $this->request->input('finish');
        $now = Carbon::now()->format('d/m/Y');

        $projects = $projects->scopeQuery(function ($query) use ($start, $finish, $now) {
            if ($start) {
                try {
                    $query->where('start', '>=', Carbon::createFromFormat('d/m/Y', $start));
                } catch (Exception $err) {
                }
            }

            if ($finish) {
                try {
                    $query->where('finish', '<=', Carbon::createFromFormat('d/m/Y', $finish));
                } catch (Exception $err) {
                }
            }
            return $query->whereHas('allocations', function ($query) use ($now) {
                return $query->whereRaw("STR_TO_DATE('{$now}','%d/%m/%Y') between start and finish");
            })->where('owner_id', \Auth::user()->id)
                ->orderBy('start', 'desc');
        })->paginate(10);

        return view('allocations.manager.index', compact('projects', 'tasks'));
    }

    public function listByProject(int $projectId, int $userId = 0)
    {
        $now = Carbon::now()->format('d/m/Y');
        $this->changeCriteria();
        $project = app(ProjectRepository::class)->find($projectId);
        $allocations = $this->repository->scopeQuery(function ($query) use ($projectId, $userId, $now) {
            if ($userId != 0) {
                return $query->where('project_id', $projectId)
                    ->whereRaw("STR_TO_DATE('{$now}','%d/%m/%Y') between start and finish")
                    ->whereNull('parent_id')
                    ->where('user_id', $userId);
            }
            return $query->where('project_id', $projectId)
                ->whereRaw("STR_TO_DATE('{$now}','%d/%m/%Y') between start and finish")
                ->whereNull('parent_id');
        })->all();

        $allocations = $allocations->map(function ($item) {
            $concludes = false;
            $item->has_task = $item->task_id || !$item->allocationTasks->isEmpty();

            foreach ($item->allocationTasks as $allocationTask) {
                if ($allocationTask->concludes) {
                    $concludes = true;
                }
            }
            $item->concludes = $concludes;
            return $item;
        });

        return $this->response->json([
            'allocations' => $allocations,
            'tasks' => $project->tasks->pluck('name', 'id'),
            'project' => app(ProjectRepository::class)->find($projectId)
        ], 200);
    }

    private function changeCriteria()
    {
        if (!(\Auth::user()->role
            ->permissions
            ->contains('slug', 'show-all-expenses'))) {
            $this->repository->popCriteria(ScopeCriteria::class);
            $this->repository->pushCriteria(CollaboratorsProjectCriteria::class);
        }
    }

    public function managerApprovedHours()
    {
        $now = Carbon::now()->format('d/m/Y');
        $approved = $this->request->input('approved');
        $projects = app(ProjectRepository::class)->scopeQuery(function ($query) use ($approved, $now) {
            return $query->where('owner_id', \Auth::user()->id)->whereHas('activities', function ($query) use ($approved) {
                if ($approved) {
                    return $query
                        ->whereIn('approved', $approved);
                }
                return $query->whereNull('approver_id')
                    ->where('approved', false);
            })->orderBy('start', 'desc');
        })->paginate(10);

        $users    = app(UserRepository::class)->pluck('name', 'id');
        $tasks    = app(TaskRepository::class)->pluck('name', 'id');
        return view('allocations.manager-approved-hours.index', compact('projects', 'users', 'tasks'));
    }

    public function managerExpense()
    {
        $now = Carbon::now()->format('d/m/Y');
        $approved = $this->request->input('approved');
        $projects = app(ProjectRepository::class)->scopeQuery(function ($query) use ($approved, $now) {
            return $query->where('owner_id', \Auth::user()->id)
                ->whereHas('expenses', function ($query) use ($approved, $now) {
                    if ($approved) {
                        return $query
                            ->whereIn('approved', $approved);
                    }
                    return $query
                        ->where('approved', false);
                });
        })->paginate(10);
        return view('allocations.manager-expenses.index', compact('projects'));
    }

    public function usersByProject(int $projectId)
    {
        $now = Carbon::now()->format('d/m/Y');
        $is_manager_task = $this->request->input('manager_task');
        $users = app(UserRepository::class)->scopeQuery(function ($query) use ($projectId, $now, $is_manager_task) {
            if ($is_manager_task) {
                return $query->whereHas('allocations', function ($query) use ($projectId, $now) {
                    return $query->where('project_id', $projectId)
                        ->whereRaw("STR_TO_DATE('{$now}','%d/%m/%Y') between start and finish")
                        ->whereNull('parent_id');
                });
            }

            return $query->whereHas('projects', function ($query) use ($projectId) {
                return $query->where('id', $projectId);
            });
        })->all();

        $users->map(function ($user) use ($projectId) {
            $user->has_pending_allocations = $user->getPedingAllocations($projectId);
            $user->has_task_concludes = $user->hasTaskConcludes($projectId);
            unset($user->allocations);
            $user->has_pending_activities = $user->getPedingActivities($projectId);
            unset($user->activities);
            return $user;
        });

        $users = $users->toArray();
        $project = app(ProjectRepository::class)->find($projectId);
        $project->has_pending_activities = $project->has_pending_activities;

        if ($is_manager_task) {
            usort($users, function ($a, $b) {
                if (!$a['has_task_concludes'] && $b['has_task_concludes']) {
                    return -1;
                } else {
                    if ($a['has_task_concludes'] && !$b['has_task_concludes']) {
                        return 1;
                    }
                }

                return 0;
            });
        }



        if (count($users) == 0) {
            return $this->response->json([
                'users' => $users,
                'project' =>  $project
            ], 404);
        }

        return $this->response->json([
            'users' => $users,
            'project' => $project
        ], 200);
    }
}
