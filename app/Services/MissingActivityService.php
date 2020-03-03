<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\MissingActivityRepositoryEloquent;

class MissingActivityService extends AbstractService
{
    public function repositoryClass() : string
    {
        return MissingActivityRepositoryEloquent::class;
    }
}