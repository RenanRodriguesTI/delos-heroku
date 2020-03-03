<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Events\AddedTasksProjectType;
use Delos\Dgp\Events\RemovedTasksProjectType;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Delos\Dgp\Repositories\Contracts\TaskRepository;
use Exception;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTypesController extends AbstractController
{
    public function getVariablesForPersistenceView() : array
    {
        return [
            'groupCompanies' => app(GroupCompanyRepository::class)->pluck('name', 'id')
        ];
    }
    public function tasks(int $projectTypeId)
    {
        $projectType = $this->repository->find($projectTypeId);

        $projectTypeTasks = $projectType->tasks;
        $tasks = app(TaskRepository::class)->all()->diff($projectType->tasks)->pluck('name', 'id')->sort();

        return $this->response
            ->view("{$this->getViewNamespace()}.tasks", compact('projectType', 'projectTypeTasks', 'tasks'));
    }

    public function addTask(int $projectTypeId, Request $request)
    {
        $this->validate($request, [
            'tasks' => 'required|array'
        ]);

        try {
            $this->service->addTask($projectTypeId, $request->input('tasks'));

            event(new AddedTasksProjectType($request->input('tasks'), $this->repository->find($projectTypeId)));

            return $this->request->input('project')
                ? $this->redirector->back()
                : $this->response->redirectToRoute('projectTypes.tasks', ['id' => $projectTypeId]);

        } catch(ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }

    public function removeTask(int $projectTypeId, int $taskId)
    {
        try {
            $this->service->removeTask($projectTypeId, $taskId);

            event(new RemovedTasksProjectType($taskId, $projectTypeId));

            return $this->request->input('project')
                ? $this->redirector->back()
                : $this->response->redirectToRoute('projectTypes.tasks', ['id' => $projectTypeId]);

        } catch (Exception $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function store()
    {
        try {
            $data = $this->getRequestDataForStoring();

            if (!$this->request->get('group_company_id')) {
                $data['group_company_id'] = \Auth::user()->group_company_id;
            }

            $this->service->create($data);

            return $this->response
                ->redirectTo($this->getInitialUrlIndex())
                ->with('success', $this->getMessage('created'));
        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }
}