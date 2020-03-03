<?php

    namespace Delos\Dgp\Http\Controllers\Api;

    use Delos\Dgp\Http\Middleware\Authorize;
    use Delos\Dgp\Services\ServiceInterface;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Redirector;
    use Illuminate\Routing\ResponseFactory;
    use Illuminate\Support\Facades\Schema;
    use Prettus\Validator\Exceptions\ValidatorException;
    use Delos\Dgp\Http\Controllers\Controller;
    use Delos\Dgp\Http\Controllers\ResourceNamesTrait;
    use Delos\Dgp\Http\Controllers\AuthorizeTrait;
    
    /**
     * Class AbstractController
     * @package Delos\Dgp\Http\Controllers
     */
    abstract class AbstractController extends Controller
    {
        // use AuthorizeTrait;
        use ResourceNamesTrait;

        /**
         * @var ServiceInterface
         */
        protected $service;
        /**
         * @var ResponseFactory
         */
        protected $response;
        /**
         * @var Redirector
         */
        protected $redirector;
        /**
         * @var \Delos\Dgp\Repositories\Contracts\RepositoryInterface
         */
        protected $repository;
        /**
         * @var Request
         */
        protected $request;

        protected $withoutPaging = false;

        /**
         * AbstractController constructor.
         *
         * @param ServiceInterface $service
         * @param ResponseFactory  $response
         * @param Redirector       $redirector
         * @param Request          $request
         */
        public function __construct(ServiceInterface $service, ResponseFactory $response, Redirector $redirector, Request $request)
        {
            // $this->middleware(Authorize::class);
            $this->service    = $service;
            $this->response   = $response;
            $this->redirector = $redirector;
            $this->repository = $service->getRepository();
            $this->request    = $request;
        }

        public function store()
        {
            try {
                $this->service->create($this->getRequestDataForStoring());
                return $this->response->json($this->getMessage('created'));
            } catch ( ValidatorException $e ) {
                return $this->response->json($e->getMessage(), 400);
            }
        }

        /**
         * @return array
         */
        protected function getRequestDataForStoring(): array
        {
            return $this->request->all();
        }

        /**
         * @param $type
         *
         * @return array|\Illuminate\Contracts\Translation\Translator|null|string
         */
        protected function getMessage($type)
        {
            $resource = ucfirst(trans("resources.{$this->getEntityName()}"));
            return trans("messages.{$type}", ['resource' => $resource]);
        }
    }