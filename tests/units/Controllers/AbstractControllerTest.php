<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Eloquent\ClientRepositoryEloquent;
use Delos\Dgp\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Routing\Route;
use Illuminate\View\View;
use Mockery;

class AbstractControllerTest extends \TestCase
{

    private function getControllerInstance()
    {

        $clientRepository = Mockery::mock(ClientRepositoryEloquent::class);
        $clientRepository->shouldReceive('withTrashed')->andReturnSelf();
        $clientRepository->shouldReceive('paginate')->andReturn([]);
        $clientRepository->shouldReceive('orderBy')->andReturn([]);
        $service = Mockery::mock(ClientService::class);

        $service->shouldReceive('getRepository')
            ->andReturn($clientRepository);

        $responseFactory = Mockery::mock(ResponseFactory::class);
        $responseFactory->shouldReceive('view')->andReturn(Mockery::mock(Response::class));

        $redirector = Mockery::mock(Redirector::class);

        $route = Mockery::mock(Route::class);
        $route->shouldReceive('getController')->andReturn(UsersController::class);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('input')->andReturnNull();
        $request->shouldReceive('fullUrl')->andReturn('');
        $request->shouldReceive('route')->andReturn($route);
        $request->shouldReceive('setUserResolver')->andReturn();
        $request->shouldReceive('wantsJson')->andReturn(false);

        \App::instance('request', $request);

        $controller = $this->getMockForAbstractClass(
            AbstractController::class,
            [$service, $responseFactory, $redirector, $request]
        );

        return $controller;

    }

    public function test_if_it_is_instance_of_controller()
    {
        $controller = $this->getControllerInstance();

        $this->assertInstanceOf(Controller::class, $controller);
    }

    public function test_index_method_return_a_response()
    {
        $this->actingAs($this->getUser());

        $controller = $this->getControllerInstance();

        $this->assertInstanceOf(View::class, $controller->index());
    }
}