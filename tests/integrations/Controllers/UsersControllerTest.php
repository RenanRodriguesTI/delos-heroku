<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 07/06/17
 * Time: 09:21
 */

namespace Delos\Dgp\Http\Controllers;

use Illuminate\View\View;

class UsersControllerTest extends \TestCase
{
    private function controller() : UsersController
    {
        return app(UsersController::class);
    }

    public function testShowRests()
    {
        $result = $this->controller()->showRests(1);
        $this->assertInstanceOf(View::class, $result);
    }

    public function testShowRestsReport()
    {
        $this->route('GET', 'users.showRestsReport', ['id' => 13]);
        $this->assertFileExists(base_path() . '/resources/views/users/user-extract.xlsx');
        $this->assertResponseStatus(302);
    }
}
