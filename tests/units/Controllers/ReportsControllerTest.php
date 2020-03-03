<?php

use Delos\Dgp\Http\Controllers\ReportsController;
use Delos\Dgp\Reports\PerformanceQueries;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\View\View;

class ReportsControllerTest extends \TestCase
{
    public function testOwnersIndex()
    {
        $this->assertTrue(app(ReportsController::class)->ownersIndex()['owners']->isDownloadable);
        $this->assertInstanceOf(View::class, app(ReportsController::class)->ownersIndex());
        $this->assertEquals(['owners', 'months', 'collaborators'], array_keys(app(ReportsController::class)->ownersIndex()->getData()));
        $this->assertEquals('reports.owners', app(ReportsController::class)->ownersIndex()->getName());
    }

    public function testUsersIndex()
    {
        $this->assertTrue(app(ReportsController::class)->usersIndex()['users']->isDownloadable);
        $this->assertInstanceOf(View::class, app(ReportsController::class)->usersIndex());
        $this->assertEquals(['users', 'months', 'collaborators'], array_keys(app(ReportsController::class)->usersIndex()->getData()));
        $this->assertEquals('reports.users', app(ReportsController::class)->usersIndex()->getName());
    }
}
