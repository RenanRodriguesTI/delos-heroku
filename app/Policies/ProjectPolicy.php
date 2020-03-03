<?php

namespace Delos\Dgp\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Entities\Project;

class ProjectPolicy
{
    use HandlesAuthorization;

    private const SLUGS_ACCEPTED = ['collaborator', 'administrative'];

    public function isOwnerOrCoOwner(User $user, Project $project)
    {
        return in_array($user->id, [$project->owner_id, $project->co_owner_id ?? null, $project->seller_id ?? null]);
    }

    public function manageProject(User $user, Project $project)
    {
        $slug = $user->role->slug;

        if(in_array($slug, self::SLUGS_ACCEPTED)  && $this->isOwnerOrCoOwner($user, $project)) {
            return true;
        }

        return (new UserPolicy())->isSuperUser($user);
    }

    public function proposalValuesDescription(User $user, Project $project)
    {
        $slug = $user->role->slug;

        if ($slug == self::SLUGS_ACCEPTED[1]) {
            return true;
        }

        if(in_array($slug, self::SLUGS_ACCEPTED)  && $this->isOwnerOrCoOwner($user, $project)) {
            return true;
        }

        return (new UserPolicy())->isSuperUser($user);
    }

    /**
     * Check has permission to show chart of hours per task
     * @param User $user
     * @param Project $project
     * @return bool
     */
    public function showDetailsHoursPerTask(User $user, Project $project)
    {
        return $user->can('show-details-hours-per-task') || $this->isOwnerOrCoOwner($user, $project);
    }

    public function showMembers(User $user, Project $project)
    {

        if(is_super_user($user)) {
            return true;
        }

        if(is_leader($user, $project)) {
            return true;
        }

        return false;
    }
}