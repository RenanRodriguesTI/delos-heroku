<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\TransportationFacilities;
use Delos\Dgp\Repositories\Contracts\TransportationFacilityRepository;
use Delos\Dgp\Presenters\TransportationFacilityPresenter;

class TransportationFacilityRepositoryEloquent extends BaseRepository implements TransportationFacilityRepository
{
    public function model()
    {
        return TransportationFacilities::class;
    }

    public function presenter()
    {
        return TransportationFacilityPresenter::class;
    }
}