<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Delos\Dgp\Entities\Holiday;
use Delos\Dgp\Presenters\HolidayPresenter;

class HolidayApiRepositoryEloquent extends BaseApiRepository implements HolidayRepository
{
	public function model()
	{
		return Holiday::class;
    }
    
    public function presenter()
    {
        return HolidayPresenter::class;
    }

    public function getByDate(Carbon $date) : ?Holiday
    {
        $collection = $this->findWhere(['date' => $date->toDateString()]);
        $holiday = $collection->first();

        return $holiday;
    }

}