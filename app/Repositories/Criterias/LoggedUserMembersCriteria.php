<?php

namespace Delos\Dgp\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class LoggedUserMembersCriteria implements CriteriaInterface
{
    private $loggedUser;
    private $relationBeforeProjects;
    private $userFieldIdName;

    public function __construct(string $userFieldIdName, string $relationBeforeProjects = '')
    {
        $this->relationBeforeProjects = $relationBeforeProjects;
        $this->userFieldIdName = $userFieldIdName;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $relation = 'projects';

        if(!empty($this->relationBeforeProjects )) {
            $relation = $this->relationBeforeProjects . '.' . $relation;
        }

        if($this->hasToAddScope()) {
            $model = $model->where(function ($query) use($relation) {
                $query->whereHas($relation, function ($query) {
                    $query->where('owner_id', $this->getLoggedUser()->id)
                        ->orWhere('co_owner_id', $this->getLoggedUser()->id);

                })->orWhere($this->userFieldIdName, $this->getLoggedUser()->id);
            });
        }

        return $model;
    }

    private function hasToAddScope() : bool
    {

        if (is_null($user = $this->getLoggedUser())) {
            return false;
        }

        return !$user->role
            ->permissions
            ->contains('slug', 'show-all-users');

    }

    private function getLoggedUser()
    {
        if(is_null($this->loggedUser)) {
            $this->loggedUser = app('auth')->getUser();
        }

        return $this->loggedUser;
    }

}