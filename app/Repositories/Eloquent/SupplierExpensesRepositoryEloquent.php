<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\SupplierExpenses;
use Delos\Dgp\Repositories\Contracts\SupplierExpensesRepository;
use Delos\Dgp\Presenters\SupplierExpensesPresenter;

class SupplierExpensesRepositoryEloquent extends BaseRepository implements SupplierExpensesRepository
{
    public function model()
    {
        return SupplierExpenses::class;
    }

    public function presenter()
    {
        return SupplierExpensesPresenter::class;
    }
}
