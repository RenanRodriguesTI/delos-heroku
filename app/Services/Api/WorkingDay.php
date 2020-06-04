<?php

namespace Delos\Dgp\Services\Api;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\HolidayApiRepository;

trait WorkingDay
{
    protected function isWorkingDay(Carbon $date)
    {
        if($date->isWeekend()) {
            return false;
        }

        $holiday = app(HolidayApiRepository::class)->getByDate($date);

        return is_null($holiday);
    }

    protected function isNonWorkingDay(Carbon $date)
    {
        return !$this->isWorkingDay($date);
    }
}