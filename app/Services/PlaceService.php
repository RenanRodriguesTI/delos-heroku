<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\PlaceRepositoryEloquent;

class PlaceService extends AbstractService
{
    public function repositoryClass() : string
    {
        return PlaceRepositoryEloquent::class;
    }
}