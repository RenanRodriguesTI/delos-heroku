<?php

namespace Delos\Dgp\Listeners;

use Delos\Dgp\Events\AddedTasksProjectType;
use Delos\Dgp\Events\ChnagedTaksProjectType;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AttachTasksInProjects
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param AddedTasksProjectType $event
     * @return void
     */
    public function handle(AddedTasksProjectType $event)
    {
        $tasks = $event->tasks;
        $projectType = $event->projectType;

        $projectType->projects
            ->each(function ($project, $key) use ($tasks) {
                $project->tasks()->attach($tasks);
            });
    }
}
