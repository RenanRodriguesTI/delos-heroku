<?php

namespace Delos\Dgp\Providers;

use Delos\Dgp\Reports\TxtReport;
use Delos\Dgp\Reports\TxtReportInterface;
use Illuminate\Support\ServiceProvider;

class ReportProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind(TxtReportInterface::class, TxtReport::class);
    }
}