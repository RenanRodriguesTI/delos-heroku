<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\CarType;
use Delos\Dgp\Repositories\Contracts\CarTypeRepository;
use Delos\Dgp\Presenters\CarTypePresenter;

class CarTypeRepositoryEloquent extends BaseRepository implements CarTypeRepository
{
    public function model()
    {
        return CarType::class;
    }

    public function presenter()
    {
        return CarTypePresenter::class;
    }
}