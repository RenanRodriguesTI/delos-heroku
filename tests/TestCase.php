<?php

    use Delos\Dgp\Entities\User;
    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Redirector;
    use Illuminate\Routing\ResponseFactory;
    use Illuminate\Routing\Route;
    use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
    use Tests\CreatesApplication;

    abstract class TestCase extends BaseTestCase
    {
        use CreatesApplication;

        public function setUp()
        {
            parent::setUp();
            session([
                        'groupCompanies' => app(\Delos\Dgp\Entities\Group::class)
                            ->all()
                            ->pluck('id')
                            ->toArray()
                    ]);
            session([
                        'companies' => app(\Delos\Dgp\Entities\Company::class)
                            ->pluck('id')
                            ->toArray()
                    ]);
            \Auth::setUser(User::find(1));
        }

        protected function getUser()
        {
            return User::find(1);
        }


        /**
         * Get mock of controller
         *
         * @param string      $repositoryClass
         * @param string      $serviceClass
         * @param string      $controllerClass
         * @param array|null  $requestData
         * @param string|null $viewName
         * @param array|null  $viewData
         *
         * @param bool        $isCreateMethod
         *
         * @return mixed
         */
        protected function getController(string $repositoryClass, string $serviceClass, string $controllerClass, array $requestData = null, string $viewName = null, array $viewData = [], bool $isCreateMethod = false)
        {
            $repository = \Mockery::mock($repositoryClass);
            $repository->shouldReceive('orderBy')
                       ->andReturn(app($repositoryClass)->orderBy('id', 'desc'));
            $repository->shouldReceive('paginate')
                       ->andReturn(app($repositoryClass)->paginate(10));

            $response = \Mockery::mock(ResponseFactory::class);
            $response->shouldReceive('view')
                     ->andReturn(view($viewName, $viewData));

            $redirector = \Mockery::mock(Redirector::class);

            $route = \Mockery::mock(Route::class);
            $route->shouldReceive('getController')
                  ->andReturn($controllerClass);

            $request = \Mockery::mock(Request::class);
            $request->shouldReceive('fullUrl')
                    ->andReturn('');
            $request->shouldReceive('get')
                    ->andReturn();
            $request->shouldReceive('has')
                    ->andReturn();
            $request->shouldReceive('input')
                    ->andReturn('');
            $request->shouldReceive('route')
                    ->andReturn($route);
            $request->shouldReceive('setUserResolver')
                    ->andReturn();
            $request->shouldReceive('url')
                    ->andReturn();
            $request->shouldReceive('query')
                    ->andReturn();
            $request->shouldReceive('all')
                    ->andReturn($requestData);
            $request->shouldReceive('session')
                    ->andReturn($requestData);
            $request->shouldReceive('wantsJson')
                    ->andReturn(false);
            \App::instance('request', $request);

            $service = \Mockery::mock($serviceClass);
            $service->shouldReceive('getRepository')
                    ->andReturn(app($repositoryClass));
            if ($isCreateMethod) {
                $service->shouldReceive('create')
                        ->andReturn(app($repositoryClass)->create($request->all()));
            }

            $controller = (new $controllerClass($service, $response, $redirector, $request));

            return $controller;
        }
    }
