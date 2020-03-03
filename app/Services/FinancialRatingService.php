<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\FinancialRatingRepositoryEloquent;

class FinancialRatingService extends AbstractService
{
    public function repositoryClass() : string
    {
        return FinancialRatingRepositoryEloquent::class;
    }
}