<?php

namespace Delos\Dgp\Policies;

use Delos\Dgp\Entities\Request;
use Delos\Dgp\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    public function approveRequest(User $user, Request $request)
    {
        return $this->hasPermission($user, 'approve-request') && $this->isRequestWaitingForApproving($request);
    }

    public function refuseRequest(User $user, Request $request)
    {
        return $this->hasPermission($user, 'refuse-request') && $this->isRequestWaitingForApproving($request);
    }

    private function isRequestWaitingForApproving(Request $request)
    {
        return is_null($request->approved);
    }

    private function hasPermission(User $user, string $slug)
    {
        return $user->role
            ->permissions
            ->contains('slug', $slug);
    }
}
