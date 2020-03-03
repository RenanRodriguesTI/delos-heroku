<?php

use Delos\Dgp\Entities\Project;
use Delos\Dgp\Entities\User;

if(!function_exists('is_leader')) {
    function is_leader(User $user, Project $project) {
        return $user->isOwnerOrCoOwner($project->id);
    }
}

if(!function_exists('is_super_user')) {
    function is_super_user(User $user) {
        $superUserRoles = ['manager', 'administrator', 'root'];

        return in_array($user->role->slug, $superUserRoles);
    }
};