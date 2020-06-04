<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Delos\Dgp\Entities\Holiday;

class HolidayApiRepositoryEloquent extends BaseApiRepository implements HolidayRepository
{
	public function model()
	{
		return Holiday::class;
	}

    public function getByDate(Carbon $date) : ?Holiday
    {
        $collection = $this->findWhere(['date' => $date->toDateString()]);
        $holiday = $collection->first();

        return $holiday;
    }

}