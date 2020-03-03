<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Entities\ProjectType;
use Delos\Dgp\Repositories\Eloquent\ProjectTypeRepositoryEloquent;
use Exception;

class ProjectTypeService extends AbstractService
{
    public function repositoryClass(): string
    {
        return ProjectTypeRepositoryEloquent::class;
    }

    public function addTask($projectTypeId, array $taskList)
    {
        $this->validator->setRules([
            'task' => "required|integer|unique:project_type_task,task_id,NULL,id,project_type_id,{$projectTypeId}"
        ]);

        foreach ($taskList as $task) {
            $this->validator->with(['task' => $task])->passesOrFail($task);
        }

        $this->repository->find($projectTypeId)->tasks()->attach($taskList);
    }

    public function removeTask($projectTypeId, $taskId)
    {
        $projectType = $this->repository->find($projectTypeId);

        $this->isDeletable($projectType, $taskId);

        $projectType->tasks()->detach($taskId);
        $projectType->projects->each(function ($project, $key) use ($taskId) {
            $project->tasks()->detach($taskId);
        });
    }

    private function isDeletable(ProjectType $projectType, int $taskId): void
    {
        $projectsCodes = '';
        $projectType->projects
            ->each(function ($project, $key) use (&$projectsCodes, $taskId) {

                $project->tasks
                    ->each(function ($task, $key) use (&$projectsCodes, $project, $taskId) {

                        if ($task->id == $taskId &&
                            $task->pivot->hour &&
                            $task->pivot->hour > 0 &&
                            strpos($projectsCodes, $project->compiled_cod) === false
                        ) {

                            strlen($projectsCodes) == 0
                                ? $projectsCodes .= $project->compiled_cod
                                : $projectsCodes .= ', ' . $project->compiled_cod;

                        }
                    });

            });

        if (strlen($projectsCodes) > 0) {
            throw new Exception(trans('exception-messages.project_types_remove_task') . $projectsCodes);
        }
    }
}