<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\AirportRepositoryEloquent;

class AirportService extends AbstractService
{
    public function repositoryClass() : string
    {
        return AirportRepositoryEloquent::class;
    }
}