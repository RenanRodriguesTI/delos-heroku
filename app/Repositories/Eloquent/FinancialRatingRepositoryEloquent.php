<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\FinancialRating;
use Delos\Dgp\Repositories\Contracts\FinancialRatingRepository;
use Delos\Dgp\Presenters\FinancialRatingPresenter;

class FinancialRatingRepositoryEloquent extends BaseRepository implements FinancialRatingRepository
{
    public function model()
    {
        return FinancialRating::class;
    }

    public function presenter()
    {
        return FinancialRatingPresenter::class;
    }
}