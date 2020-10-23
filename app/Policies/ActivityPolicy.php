<?php

namespace Delos\Dgp\Policies;

use Delos\Dgp\Entities\Project;
use Illuminate\Auth\Access\HandlesAuthorization;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Entities\Activity;

class ActivityPolicy
{
    use HandlesAuthorization;

    private function isThisUserLeaderOfProject(User $user, Project $project)
    {
        return $project->owner_id === $user->id
            ||
            $project->co_owner_id === $user->id;
    }

    public function destroy(User $user, Activity $activity)
    {
        if ($this->isThisUserLeaderOfProject($user, $activity->project)) {
            return true;
        }

        if ($user->can('destroy-activity') && $user->role->name !='Collaborador') {
            return true;
        }

        return $user->id === $activity->user_id;
    }

    public function approve(User $user, Activity $activity){
        if ($this->isThisUserLeaderOfProject($user, $activity->project)) {
            return true;
        }

        if ($user->can('approve-activity') && $user->role->name !='Collaborador') {
            return true;
        }

        return false;
    }


    public function reprove(User $user, Activity $activity){
        if ($this->isThisUserLeaderOfProject($user, $activity->project)) {
            return true;
        }

        if ($user->can('approve-activity') && $user->role->name !='Collaborador') {
            return true;
        }

        return false;
    }
}
