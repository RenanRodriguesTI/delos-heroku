<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\ExpenseTypeRepository;

class ExpenseTypeService extends AbstractService
{
    public function repositoryClass() : string
    {
        return ExpenseTypeRepository::class;
    }

}