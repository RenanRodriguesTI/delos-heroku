<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Expense;
use Delos\Dgp\Presenters\ExpensePresenter;
use Delos\Dgp\Repositories\Contracts\ExpenseRepository;
use Delos\Dgp\Repositories\Criterias\Expense\FilterCriteria;
use Delos\Dgp\Repositories\Criterias\Expense\ScopeCriteria;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;

class ExpenseRepositoryEloquent extends BaseRepository implements ExpenseRepository
{
    protected $requests;

    public function __construct(Application $app, RequestRepositoryEloquent $requests)
    {
        $this->requests = $requests;
        parent::__construct($app);
    }

    public function boot()
    {
        parent::boot();
        $this->pushCriteria(ScopeCriteria::class);
        $this->pushCriteria(FilterCriteria::class);
    }

    protected $fieldSearchable = [
        'invoice' => 'like'
    ];

    public function model()
    {
        return Expense::class;
    }

    public function presenter()
    {
        return ExpensePresenter::class;
    }

    public function findWhereUserCompanyId($id)
    {

        $expenses = $this->model
            ->withTrashed()
            ->where(function (Builder $query) use ($id) {
                $query->where('exported', '=', false)
                    ->whereHas('user.company', function (Builder $query) use ($id) {

                        if (strpos($id, 'partner_business') !== false) {
                            $query->where('is_partner_business', true);
                            $id = explode(' - partner_business', $id)[0];
                        } else {
                            $query->where('is_partner_business', false);
                        }

                        $query->where('id', '=', $id);
                    });
            });

        return $expenses->get();
    }
}