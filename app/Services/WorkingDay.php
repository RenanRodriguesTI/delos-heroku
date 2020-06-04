<?php

namespace Delos\Dgp\Services;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;

trait WorkingDay
{
    protected function isWorkingDay(Carbon $date,$exception=false)
    {
        if($date->isWeekend() && !$exception) {
            return false;
        }

        $holiday = app(HolidayRepository::class)->getByDate($date);

        return is_null($holiday) || $exception;
    }

    protected function isNonWorkingDay(Carbon $date)
    {
        return !$this->isWorkingDay($date);
    }
}