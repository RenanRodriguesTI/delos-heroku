<?php

namespace Delos\Dgp\Repositories\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ExpenseRepository extends RepositoryInterface
{
    public function findWhereUserCompanyId($id);
}