<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\UserRepository;
use Delos\Dgp\Repositories\Criterias\LoggedUserMembersCriteria;
use Delos\Dgp\Repositories\Criterias\MissingActivity\UserCriteria;

class MissingActivitiesController extends AbstractController
{

    protected function getVariablesForIndexView(): array
    {
        return [
            'users' => app(UserRepository::class)->pluck('name', 'id')
        ];

    }

    public function index()
    {

        $this->repository->pushCriteria(new LoggedUserMembersCriteria('user_id', 'user'));
        $this->repository->pushCriteria(new UserCriteria());

        return parent::index();
    }
}
