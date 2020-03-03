<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 22/08/17
 * Time: 15:10
 */

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Plan;
use Delos\Dgp\Presenters\PlanPresenter;
use Delos\Dgp\Repositories\Contracts\PlanRepository;

class PlanRepositoryEloquent extends BaseRepository implements PlanRepository
{
    public function model()
    {
        return Plan::class;
    }

    public function presenter()
    {
        return PlanPresenter::class;
    }
}