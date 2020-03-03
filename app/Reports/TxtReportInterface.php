<?php

namespace Delos\Dgp\Reports;

use Illuminate\Support\Collection;

interface TxtReportInterface
{
    public function generate(Collection $collection);
}