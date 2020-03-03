<?php

namespace Delos\Dgp\Repositories\Criterias\TimeOffWork;

use Delos\Dgp\Entities\User;
use Delos\Dgp\Exceptions\NoLoggedUserException;
use Delos\Dgp\Policies\UserPolicy;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ScopeCriteria implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereNull('project_id')
            ->where('task_id', 91);

        try {
            $user = $this->getLoggedUser();

            if($this->hasToApplyScope($user)) {
                $model = $this->applyScope($model, $user);
            }

        } catch (NoLoggedUserException $e) {

        }

        return $model;
    }

    private function getLoggedUser() : User
    {
        $user = app('auth')->getUser();

        if(is_null($user)) {
            throw new NoLoggedUserException('Expected a logged user');
        }

        return $user;
    }

    private function hasToApplyScope(User $user) : bool
    {
        if ($user->can('show-all-rests-unapproved'))
        {
            return false;
        }

        return !(new UserPolicy())->isSuperUser($user);
    }

    private function applyScope($model, User $user)
    {
        $membersIds = app(UserRepository::class)
            ->getMembersIdsByLeaderId($user->id);

        $model = $model->where(function($query) use($user, $membersIds) {
            array_push($membersIds, $user->id);
            $query->whereIn('user_id', array_unique($membersIds));
        });

        return $model;
    }
}