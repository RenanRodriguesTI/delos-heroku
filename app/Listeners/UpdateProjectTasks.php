<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\EditedProjectEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateProjectTasks implements ShouldQueue
{

    public function handle(EditedProjectEvent $event)
    {
        $project = $event->editedProject;
        $tasksIds = $project
            ->projectType
            ->tasks
            ->pluck('id');

        $project->tasks()
            ->sync($tasksIds);
    }
}
