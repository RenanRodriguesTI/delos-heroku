<?php

use Delos\Dgp\Http\Controllers\RequestsController;
use Delos\Dgp\Repositories\Contracts\RequestRepository;
use Delos\Dgp\Services\RequestService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Created by PhpStorm.
 * User: allan
 * Date: 01/06/18
 * Time: 15:39
 */

class RequestsControllerTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    public function testResponseIndex()
    {
//        Arrange
        $controller = $this->getController(RequestRepository::class, RequestService::class, RequestsController::class, [], 'requests.index');

//        ACT
        $index = $controller->index();

//        Assert
        $this->assertEquals('requests.index', $index->getName());
        $this->assertInstanceOf(LengthAwarePaginator::class, $index['requests']);
        $this->assertLessThanOrEqual(10, $index['requests']->getCollection()->count());
        foreach ($index['requests']->getCollection() as $key => $item) {
            $this->assertEquals([
                'id',
                'requester_id',
                'project_id',
                'parent_id',
                'created_at',
                'updated_at',
                'approved',
                'reason',
                'deleted_at',
                'start',
                'finish',
                'approver_id',
                'notes'
            ], array_keys($item->getAttributes()));
        }

        $keys = ['users', 'projects', 'requests'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $index->getData());
        }
    }
}