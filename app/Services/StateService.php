<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\StateRepositoryEloquent;

class StateService extends AbstractService
{
    public function repositoryClass() : string
    {
        return StateRepositoryEloquent::class;
    }
}