<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\TransportationFacilityRepositoryEloquent;

class TransportationFacilityService extends AbstractService
{
    public function repositoryClass() : string
    {
        return TransportationFacilityRepositoryEloquent::class;
    }

}