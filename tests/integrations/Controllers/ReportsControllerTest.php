<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 14/06/17
 * Time: 10:17
 */

namespace Delos\Dgp\Http\Controllers;

use Illuminate\View\View;

class ReportsControllerTest extends \TestCase
{
    private function controller() : ReportsController
    {
        return app(ReportsController::class);
    }

    public function testReportOwners()
    {
        $result = $this->controller()->ownersIndex();

        $this->assertFileExists(base_path() . '/resources/views/reports/owners.xlsx');

        $this->assertInstanceOf(View::class, $result);

        $this->assertArrayHasKey('owners', $result->getData());
        $this->assertArrayHasKey('collaborators', $result->getData());

        $structure = ['name' , 'total_projects', 'total_budgets_in_projects', 'total_hours_expended'];

        foreach ($result->getData()['owners'] as $data) {
            $keys = array_keys($data);
            $this->assertEquals($structure, $keys);
        }

        $this->assertTrue($result->getData()['owners']->isDownloadable);

        $this->assertEquals('reports.owners', $result->getName());
    }

    public function testReportUsers()
    {
        $result = $this->controller()->usersIndex();

        $this->assertFileExists(base_path() . '/resources/views/reports/users.xlsx');

        $this->assertInstanceOf(View::class, $result);

        $this->assertArrayHasKey('users', $result->getData());
        $this->assertArrayHasKey('collaborators', $result->getData());

        $structure = ['name' , 'total_projects', 'total_right_projects', 'total_wrong_projects'];

        foreach ($result->getData()['users'] as $data) {
            $keys = array_keys($data);
            $this->assertEquals($structure, $keys);
        }

        $this->assertTrue($result->getData()['users']->isDownloadable);

        $this->assertEquals('reports.users', $result->getName());
    }
}
