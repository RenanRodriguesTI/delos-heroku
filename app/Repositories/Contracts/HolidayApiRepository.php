<?php

namespace Delos\Dgp\Repositories\Contracts;


use Carbon\Carbon;
use Delos\Dgp\Entities\Holiday;

interface HolidayApiRepository extends RepositoryInterface
{
    public function getByDate(Carbon $date) : ?Holiday;
}