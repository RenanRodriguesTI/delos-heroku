<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\City;
use Delos\Dgp\Repositories\Contracts\CityRepository;
use Delos\Dgp\Presenters\CityPresenter;

class CityRepositoryEloquent extends BaseRepository implements CityRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    public function model()
    {
        return City::class;
    }

    public function presenter()
    {
        return CityPresenter::class;
    }
}