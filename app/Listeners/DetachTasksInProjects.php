<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\RemovedTasksProjectType;
use Delos\Dgp\Repositories\Contracts\ProjectTypeRepository;
use Delos\Dgp\Repositories\Contracts\TaskRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DetachTasksInProjects
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RemovedTasksProjectType  $event
     * @return void
     */
    public function handle(RemovedTasksProjectType $event)
    {
        $projectType = app(ProjectTypeRepository::class)->find($event->projectTypeId);

        $projectType->projects
            ->each(function ($project, $key) use ($event) {
                $project->tasks()->detach($event->taskId);
            });
    }
}
