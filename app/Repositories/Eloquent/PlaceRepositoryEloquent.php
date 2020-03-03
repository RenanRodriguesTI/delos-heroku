<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Place;
use Delos\Dgp\Repositories\Contracts\PlaceRepository;
use Delos\Dgp\Presenters\PlacePresenter;

class PlaceRepositoryEloquent extends BaseRepository implements PlaceRepository
{
    public function model()
    {
        return Place::class;
    }

    public function presenter()
    {
        return PlacePresenter::class;
    }
}