<?php

namespace Delos\Dgp\Observers;

use Delos\Dgp\Entities\Request;
use Illuminate\Foundation\Application;

class RequestObserver
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function deleting(Request $request)
    {
        $request->expenses()->delete();
    }

    public function restoring(Request $request)
    {
        $request->expenses()->onlyTrashed()->restore();
    }
}