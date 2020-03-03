<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Entities\Audit;
use Delos\Dgp\Repositories\Eloquent\AuditRepositoryEloquent;
use Prettus\Validator\Contracts\ValidatorInterface;

class AuditService extends AbstractService
{
    public function repositoryClass() : string
    {
        return AuditRepositoryEloquent::class;
    }
}