<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Role;
use Delos\Dgp\Repositories\Contracts\RoleRepository;
use Delos\Dgp\Presenters\RolePresenter;

class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    public function model()
    {
        return Role::class;
    }

    public function presenter()
    {
        return RolePresenter::class;
    }
}