<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\ProjectType;
use Delos\Dgp\Repositories\Contracts\ProjectTypeRepository;
use Delos\Dgp\Presenters\ProjectTypePresenter;

class ProjectTypeRepositoryEloquent extends BaseRepository implements ProjectTypeRepository
{
    protected $fieldSearchable = [
        'name' => 'like'
    ];

    public function model()
    {
        return ProjectType::class;
    }

    public function presenter()
    {
        return ProjectTypePresenter::class;
    }
}