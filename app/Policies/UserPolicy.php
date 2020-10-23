<?php

namespace Delos\Dgp\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Delos\Dgp\Entities\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function isSuperUser(User $user)
    {
        return in_array($user->role->slug, ['manager', 'administrator', 'root']);
    }

    public function isRoot(User $user)
    {
        return in_array($user->role->slug, ['root']);
    }

    public function showOwnInformation(User $user, User $member)
    {

        if($this->isSuperUser($user)) {
            return true;
        }

        return $user->id == $member->id;
    }

    public function loggedUserIsASuperUser()
    {
        $user = app('auth')->getUser();

        if(is_null($user)) {
            throw new \UnexpectedValueException('Expected a logged user');
        }

        return $this->isSuperUser($user);
    }

    public function isPartnerBusinessOrRoot(User $user){
        return $this->isRoot($user) || $user->is_partner_businees;
    }
}
