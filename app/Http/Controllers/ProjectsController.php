<?php

namespace Delos\Dgp\Http\Controllers;

use Aws\Api\Validator;
use Charts;
use ConsoleTVs\Charts\Builder\Chart;
use ConsoleTVs\Charts\Builder\Multi;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Repositories\Contracts\{
    ActivityRepository, ClientRepository, CompanyRepository, FinancialRatingRepository as FrRepository, GroupRepository, ProjectTypeRepository, TaskRepository, UserRepository
};
use Delos\Dgp\Repositories\Criterias\Project\FilterCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Prettus\Validator\Exceptions\ValidatorException;
use Delos\Dgp\Entities\ProjectProposalValue;
use Maatwebsite\Excel\Facades\Excel;


class ProjectsController extends AbstractController
{
    protected function getVariablesForPersistenceView(): array
    {
        return [
            'frs' => app(FrRepository::class)->pluck('description', 'id'),
            'users' => app(UserRepository::class)->pluck('name', 'id'),
            'projectTypes' => app(ProjectTypeRepository::class)->pluck('name', 'id'),
            'groups' => app(GroupRepository::class)->pluck('name', 'id'),
            'companies' => app(CompanyRepository::class)->pluck('name', 'id'),
            'usersRoleClient' => app(UserRepository::class)->getFromClientRole()->pluck('name', 'id'),
            'accepted' => app('auth')->getUser()->name === 'VERONICA SALVATI'
        ];
    }

    public function index()
    {
        $this->repository->pushCriteria(FilterCriteria::class);
        $this->repository->orderBy('id', 'desc');
        return parent::index();
    }

    public function getClients($groupId): array
    {
        return app(ClientRepository::class)
            ->findByField('group_id', $groupId, ['name', 'id'])
            ->pluck('name', 'id');
    }

    public function edit(int $id)
    {
        $entity = $this->repository->find($id);
        $group = $entity->clients->first()->group;
        $selectedGroup = $group->id;
        $clients = $group->clients()->pluck('name', 'id');

        $minDateExtension = $entity->finish;
        $minDateExtension->addDay(1);

        $data = [
            $this->getEntityName() => $entity,
            'selectedClients' => $entity->clients->pluck('id')->toArray(),
            'selectedGroup' => $selectedGroup,
            'clients' => $clients,
            'action' => 'edited',
            'tasks' => $this->getTasksToEditView($entity),
            'minDateExtension' => $minDateExtension,
        ];

        $variables = array_merge($data, $this->getVariablesForEditView());

        return $this->response->view("{$this->getViewNamespace()}.edit", $variables);
    }

    public function membersToAdd(int $id)
    {
        $userRepository = app(UserRepository::class);
        $project = $this->repository->find($id);
        $members =$project->members;
    
        $collaborators = $userRepository->getAllUsersWhoCanBeMembers(['id', 'name']);
        $users = $collaborators->diff($members);
        $users = $users->pluck('name', 'id');

        return $this->response
            ->view("{$this->getViewNamespace()}.members", compact('project', 'members', 'users'));
    }

    public function addMember(int $projectId, Request $request)
    {

        $this->authorize('manage-project', $this->repository->find($projectId));

        try {

            $this->service->addMember($projectId, $request->input('members'));

            return $this->response
                ->redirectToRoute('projects.membersToAdd', ['id' => $projectId]);

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }

    public function changeHoursPs(int $projectId, int $memberId){
        $this->authorize('manage-project', $this->repository->find($projectId));

        try {

            $userRepository = app(UserRepository::class);
            $project = $this->repository->find($projectId);
            $members = $project->members->where('id',$memberId);
            
            
            if(!empty($project) && !empty($members)){
                foreach($members as $member){
                    if($memberId == $member->id)
                    $project->members()->updateExistingPivot($memberId,['hours'=>($member->pivot->hours == 0)?1:0]);
                }
                
            }

            return $this->response
                ->redirectToRoute('projects.membersToAdd', ['id' => $projectId]);

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }

    public function removeMember(int $projectId, int $memberId)
    {
        try {

            $this->authorize('manage-project', $this->repository->find($projectId));
            $this->service->removeMember($projectId, $memberId);

            return $this->response
                ->redirectToRoute('projects.membersToAdd', ['id' => $projectId]);

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors(new MessageBag(['member_id' => ['Não é possível remover o líder do projeto.']]))
                ->withInput();
        }
    }

    public function show(int $id)
    {
        if ($this->request->wantsJson()) {
            $data = $this->repository->withTrashed()->find($id);
            return $this->response->json($data, 200);
        }

        $project = Project::query()
            ->withoutGlobalScopes()
            ->find($id);

        $members = $project->members->implode('name', ', ');

        $chartPercentage = $this->getChartPecentageProgress($project);
        $chartHoursPerTask = $this->getChartWithHoursPerTask($project);
        $chartBudgetedVsActualHours = $this->getChartWithBudgetedVsActualHours($project);
        $chartBudgetedVsActualValues = $this->getChartWithBudgetedVsActualValues($project);

        return $this->response
            ->view('projects.show', compact('project', 'members', 'chartHoursPerTask', 'chartBudgetedVsActualHours', 'chartBudgetedVsActualValues', 'chartPercentage'));
    }

    public function tasksToAdd(int $projectId)
    {
        $project = $this->repository->find($projectId);
        $projectTasks = $project->tasks;
        $tasks = app(TaskRepository::class)
            ->findWhereNotIn('id', $project->tasks->pluck('id')->toArray())
            ->pluck('name', 'id')
            ->sort();
        return $this->response
            ->view("{$this->getViewNamespace()}.tasks", compact('project', 'projectTasks', 'tasks'));
    }

    public function tasks(int $projectId)
    {
        $tasks = app(TaskRepository::class)
            ->getTasksPairsByProjectId($projectId);

        return $tasks;
    }

    public function create()
    {
        $data = $this->getVariablesForCreateView();
        /* @var $request Request */
        $request = app()->make(Request::class);
        $session = $request->session();
        $clients = app(ClientRepository::class)->findByField('group_id', $session->getOldInput('group_id'))->pluck('name', 'id');

        if ($session->hasOldInput('group_id')) {
            $data['clients'] = $clients;
        }

        $project = new Project();
        $project->start = now()->format('d/m/Y');
        $project->finish = now()->format('d/m/Y');
        $data['project'] = $project;
        $data['selectedClients'] = [];
        $data['clients'] = [];
        $data['selectedGroup'] = null;
        return view('projects.create', $data);
    }

    public function members(int $projectId)
    {
        $project = Project::find($projectId);

        $members = User::whereHas('projects', function ($query) use ($projectId) {
            $query->where('id', $projectId);
        })->pluck('name', 'id');


        if(!request()->user()->can('showMembers', $project)) {
            $members = $members->reject(function ($member, $id) use($project) {
                $user = $project->members->where('id',$id)->first();
                return $id != request()->user()->id || $user->pivot->hours ==0 ;
            });
        }

        return $members;
    }

    public function store()
    {
        try {
            $this->service->create($this->getRequestDataForStoring());
            return redirect()->route('projects.index');

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }

    }

    public function storeTasks(int $id)
    {
        try {
            $data = $this->getRequestDataForStoring();

            $this->service->addTasksWithHour($id, $data);
            return $this->response
                ->redirectTo($this->getInitialUrlIndex())
                ->with('success', $this->getMessage($data['hours-per-task']));

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }

    /**
     * Only update extra expenses
     * @param Request $request
     * @param int $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function updateExtraExpenses(Request $request, int $id)
    {
        try {
            $this->repository->makeModel()
                ->withTrashed()
                ->find($id)
                ->update([
                    'extra_expenses' => doubleval(str_replace(',', '.', str_replace('.', '', $request->all()['extra_expenses'])))
                ]);
            return $this->response
                ->json(['message' => trans("messages.edited", ['resource' => 'Despesas extras'])], 200);

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    private function getDatasToIndexAfterStore($project): array
    {
        $data = $this->getVariablesForCreateView();
        $data['tasks'] = $project->projectType->tasks;
        $data['project'] = $project;
        $clients = app(ClientRepository::class)->findByField('group_id', session()->getOldInput('group_id'))->pluck('name', 'id');
        $data['clients'] = $clients;
        $data['action'] = 'created';
        return $data;
    }

    private function getTasksToEditView($entity)
    {
        $tasks = [];
        $idsTasksEntity = [];

        foreach ($entity->tasks as $task) {
            array_push($tasks, $task);
            array_push($idsTasksEntity, $task->id);
        }

        $tasksRepository = app(TaskRepository::class);

        $projectTypeTasks = $tasksRepository->makeModel()
            ->where(function (Builder $query) use ($entity, $idsTasksEntity) {
                $query->whereHas('projectTypes', function (Builder $query) use ($entity, $idsTasksEntity) {
                    $query->where('id', '=', $entity->projectType->id);
                });
            })
            ->whereNotIn('id', $idsTasksEntity)
            ->get();

        foreach ($projectTypeTasks as $projectTypeTask) {
            array_push($tasks, $projectTypeTask);
        }

        return $tasks;
    }

    private function getChartWithHoursPerTask($project)
    {
        $chart = $this->getBasicChartConfiguration("bar", "Gráfico horas por tarefa x Horas lançadas na tarefa");

        $hoursBudget = [];
        $hoursActivities = [];
        $names = [];
        $activityRepository = app(ActivityRepository::class);
        $taskRepository = app(TaskRepository::class);
        $tasks = $project->tasks()->where('hour', '<>', '')->whereNotNull('hour')->get();
        $ids = [];

        foreach ($tasks as $task) {
            $hours = $activityRepository
                ->withTrashed()
                ->findWhere(['project_id' => $project->id, 'task_id' => $task->id])
                ->sum('hours');

            array_push($hoursBudget, $task->pivot->hour);
            array_push($names, $task->name);
            array_push($hoursActivities, $hours);
            array_push($ids, $task->id);
        }

        $tasksActivities = $taskRepository
            ->makeModel()
            ->whereHas('projects', function (Builder $query) use ($project) {
                $query->where('id', $project->id);
            })
            ->whereHas('activities', function (Builder $query) use ($project) {
                $query->where('project_id', '=', $project->id);
            })
            ->whereNotIn('id', $ids)
            ->get();

        foreach ($tasksActivities as $task) {
            $hours = $activityRepository->makeModel()
                ->withTrashed()
                ->where('project_id', $project->id)
                ->where('task_id', $task->id)
                ->withTrashed()
                ->sum('hours');

            array_push($hoursBudget, 0);
            array_push($names, $task->name);
            array_push($hoursActivities, $hours);
            array_push($ids, $task->id);
        }

        $chart->dataset('Horas Orçadas', $hoursBudget)
            ->dataset('Horas Lançadas', $hoursActivities)
            ->labels($names);

        return $chart;
    }

    /**
     * Create Budgeted vs Actual Hours Chart
     * @param $project
     * @return Multi
     */
    private function getChartWithBudgetedVsActualHours($project)
    {
        $chart = $this->getBasicChartConfiguration("bar", "Gráfico Orçado vs Real (Horas)");

        $hoursBudget = [$project->budget];
        $hoursReal = [
            $project->activities()
                ->withTrashed()
                ->get()
                ->sum('hours')
        ];

        $names = ['Horas'];

        $chart->dataset('Horas Orçadas', $hoursBudget)
            ->dataset('Horas gastas', $hoursReal)
            ->labels($names);

        return $chart;
    }

    /**
     * Create Budgeted vs Actual Values Chart
     * @param $project
     * @return Multi
     */
    private function getChartWithBudgetedVsActualValues($project)
    {
        $chart = $this->getBasicChartConfiguration("bar", "Gráfico Orçado vs Real (Valores)");

        $hoursBudget = [$project->budget];
        $hoursReal = [
            $project->activities()
                ->withTrashed()
                ->get()
                ->sum('hours')
        ];

        $valuesBudget = [$project->proposal_value];

        $totalLabor = $project->activities()
            ->withTrashed()
            ->get()
            ->mapWithKeys(function ($item) {
                return [['labor' => $item->hours * $item->user->value]];
            })->sum('labor');

        $totalValue = $project->expenses()
            ->withTrashed()
            ->get()
            ->mapWithKeys(function ($item) {
                return [['value' => doubleval(str_replace(',', '.',str_replace('.', '', $item->value)))]];
            })->sum('value');

        $valuesReal = [
            $project->financialRating->cod == 02
                ? $totalValue + $totalLabor + $project->extra_expenses
                : $project->extra_expenses
        ];

        $names = ['Valores'];

        $chart->dataset('Valor Orçado', $valuesBudget)
            ->dataset('Valor Gasto', $valuesReal)
            ->labels($names);

        return $chart;
    }

    protected function makeResponseForListing()
    {
        if ($this->request->wantsJson()) {
            $data = $this->getDataForListingWithoutPaging();
            return $this->response->json($data, 200);
        }
        return parent::makeResponseForListing();
    }

    /**
     * Basic configuracion to all charts of projects
     * @return Multi
     */
    private function getBasicChartConfiguration(string $type, string $title): Multi
    {
        $chart = Charts::multi($type, 'highcharts')
            ->title($title)
            ->colors(['#134217', '#980000'])
            ->responsive(true)
            ->template("material");
        return $chart;
    }

    /**
     * Chart to determinate progress of project
     * @param $project
     * @return Chart
     */
    private function getChartPecentageProgress($project): Chart
    {
        $percentage = round($project->getSpentHours() / $project->budget * 100, 2);
        $chartPercentage = Charts::create('percentage', 'justgage')->title('Progresso do Projeto')->values([$percentage, 0, 100]);
        return $chartPercentage;
    }

    public function proposalValuesIndex(int $id)
    {
        $project = $this->repository->withTrashed()->with("proposalValueDescriptions")->find($id);

        return $this->response->view("{$this->getViewNamespace()}.proposal-values-description.index", compact("project"));
    }

    public function proposalValuesCreate(int $id)
    {
        $project = $this->repository->withTrashed()->with('clients')->find($id);
        $clients = $project->clients->pluck('name', 'id');
        $avaliableValue = $this->repository->withTrashed()->getAvaliableProposalValues($id);
        return $this->response->view("{$this->getViewNamespace()}.proposal-values-description.create", compact("project", "avaliableValue", "clients"));
    }

    public function proposalValuesStore( int $id)
    {
        try {
            $this->service->createProposalValue($this->getRequestDataForStoring());
            return $this->response->redirectToRoute('projects.descriptionValues.index', ['id' => $this->getRequestDataForStoring()['project_id']])->with('success', 'Descrição de Proposta de Valor adicionada com sucesso');

        } catch ( ValidatorException $e ) {
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }

    }

    public function proposalValuesEdit(int $id)
    {
        $proposalValueDescription  = ProjectProposalValue::with('project', 'project.clients')->find($id);
        $project        = $proposalValueDescription->project;
        $clients        = $project->clients->pluck('name', 'id');
        $avaliableValue = $this->repository->withTrashed()->getAvaliableProposalValues($project->id, $proposalValueDescription->id);

        return $this->response->view("{$this->getViewNamespace()}.proposal-values-description.edit", compact("proposalValueDescription", "avaliableValue", "clients", 'project'));
    }

    public function proposalValuesUpdate( int $id)
    {
        try {
            $this->service->updateProposalValue($this->getRequestDataForStoring(), $id);
            return $this->response->redirectToRoute('projects.descriptionValues.index', ['id' => $this->getRequestDataForStoring()['project_id']])->with('success', 'Descrição de Proposta de Valor editada com sucesso');

        } catch ( ValidatorException $e ) {
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }

    }

    public function proposalValuesDestroy(int $projectId, int $projectProposalValueId)
    {
        $this->service->deleteProposalValue($projectId, $projectProposalValueId);
        return $this->response->redirectToRoute("projects.descriptionValues.index", ["id" => $projectId])->with('success', 'Descrição de Proposta de Valor removida com sucesso');
    }


    /**
         * @param int $id
         */
        public function proposalValuesDescriptionReport(int $id)
        {
            $excelProposal = $this->repository->withTrashed()->with("proposalValueDescriptions")->find($id);
            $proposalValueDescriptions = $excelProposal->proposalValueDescriptions->map(function ($item) {
                return [
                    'client' => $item->clients->implode('name'),
                    'invoice_number' =>$item->invoice_number,
                    'month' => $item->month->format('d/m/Y'),
                    'description' => $item->description,
                    'notes' => $item->notes,
                    'value' => $item->value,

                ];
            })->toArray();
            Excel::load('resources/views/projects/proposal-values-description/proposal-values-description.xlsx', function ($reader) use ($excelProposal, $proposalValueDescriptions) {

                $reader->sheet('Descrição do Valor de Proposta')->setCellValue('C1', $excelProposal->full_description);
                $reader->sheet('Descrição do Valor de Proposta')->setCellValue('C3', number_format($excelProposal->proposal_value, 2, '.', ','));
                $reader->sheet('Descrição do Valor de Proposta')->setCellValue('C4', date('d/m/Y H:i:s'));
                $reader->sheet('Descrição do Valor de Proposta')->fromArray($proposalValueDescriptions, null, 'A7', false, false);

            })->download('xlsx');
        }
}