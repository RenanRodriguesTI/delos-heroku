<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\PermissionRepositoryEloquent;

class PermissionService extends AbstractService
{
    public function repositoryClass() : string
    {
        return PermissionRepositoryEloquent::class;
    }
}