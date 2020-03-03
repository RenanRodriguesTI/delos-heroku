<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\CityRepositoryEloquent;

class CityService extends AbstractService
{
    public function repositoryClass() : string
    {
        return CityRepositoryEloquent::class;
    }
}