<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Group;
use Delos\Dgp\Repositories\Contracts\GroupRepository;
use Delos\Dgp\Presenters\GroupPresenter;

class GroupRepositoryEloquent extends BaseRepository implements GroupRepository
{
    protected $fieldSearchable = [
        'cod',
        'name' => 'like'
    ];

    public function model()
    {
        return Group::class;
    }

    public function presenter()
    {
        return GroupPresenter::class;
    }
}