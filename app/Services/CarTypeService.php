<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\CarTypeRepositoryEloquent;

class CarTypeService extends AbstractService
{
    public function repositoryClass() : string
    {
        return CarTypeRepositoryEloquent::class;
    }
}