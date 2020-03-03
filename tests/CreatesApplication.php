<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/02/18
 * Time: 14:46
 */

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}