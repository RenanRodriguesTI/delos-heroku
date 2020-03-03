<?php

namespace Delos\Dgp\Observers;

use Delos\Dgp\Entities\Activity;

class ActivityObserver
{
    public function created(Activity $activity)
    {
        $project = $activity->project;

        if(!is_null($project)) {
            $lastActivity = $activity->created_at;
            $project->last_activity = $lastActivity->toDateTimeString();
            $project->timestamps = false;
            $project->save();
        }
    }
}