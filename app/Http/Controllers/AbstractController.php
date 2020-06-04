<?php

    namespace Delos\Dgp\Http\Controllers;

    use Delos\Dgp\Http\Middleware\Authorize;
    use Delos\Dgp\Reports\ExcelReport;
    use Delos\Dgp\Services\ServiceInterface;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Redirector;
    use Illuminate\Routing\ResponseFactory;
    use Illuminate\Support\Facades\Schema;
    use Prettus\Validator\Exceptions\ValidatorException;

    /**
     * Class AbstractController
     * @package Delos\Dgp\Http\Controllers
     */
    abstract class AbstractController extends Controller
    {
        use ExcelReport, ResourceNamesTrait, AuthorizeTrait;

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
            $this->middleware(Authorize::class);
            $this->service    = $service;
            $this->response   = $response;
            $this->redirector = $redirector;
            $this->repository = $service->getRepository();
            $this->request    = $request;
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Delos\Dgp\Exceptions\FileDoesNotExistException
         */
        public function index()
        {
            if ( $this->isFileDownload() ) {
                $data     = $this->getDataForListingWithoutPaging();
                $filename = $this->getReportFilename();
                $this->download($data['data'], $filename);
            }

            if ( $this->request->wantsJson() ) {
                $data = $this->getDataForListingWithoutPaging();
                return $this->response->json($data);
            }

            $this->guardUrlIndex();

            $viewName  = $this->getViewNamespace() . '.index';
            $indexData = $this->withoutPaging ? $this->getAllDataWithoutTransformer() : $this->getPagingDataForListing();

            $data = [
                $this->getCollectionName() => $indexData
            ];

            $data = array_merge($data, $this->getVariablesForIndexView());

            return view($viewName, $data);
        }

        /**
         * @return bool
         */
        protected function isFileDownload()
        {
            $queryStringReport = $this->request->input('report');
            return $queryStringReport === 'xlsx';
        }

        /**
         * @return mixed
         */
        protected function getDataForListingWithoutPaging()
        {
            return $this->repository->skipPresenter(false)->withTrashed()->all();
        }

        /**
         * @return mixed
         */
        protected function getAllDataWithoutTransformer()
        {
            return $this->repository->withTrashed()->all();
        }

        /**
         * @return string
         */
        protected function getReportFilename(): string
        {
            $view     = $this->getViewNamespace();
            $filename = resource_path("views/$view/$view.xlsx");

            return $filename;
        }

        /**
         * @return mixed
         */
        protected function getPagingDataForListing()
        {
            $this->repository->orderBy('id', 'desc');
            return $this->repository->withTrashed()->paginate(10);
        }

        /**
         * @return array
         */
        protected function getVariablesForIndexView(): array
        {
            return [];
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function restore(int $id)
        {
            $this->repository->restore($id);
            return $this->response->redirectToRoute($this->getRouteAliasForIndexAction())->with('success', $this->getMessage('restored'));
        }

        /**
         * @param $type
         *
         * @return array|\Illuminate\Contracts\Translation\Translator|null|string
         */
        protected function getMessage($type)
        {
            $classexpection =['supplierExpense'];
            if(array_search($this->getEntityName(),$classexpection) === false){
                $resource = ucfirst(trans("resources.{$this->getEntityName()}"));
            } else{
                $resource = 'Despesa';
            }
           
            return trans("messages.{$type}", ['resource' => $resource]);
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit(int $id)
        {
            $data = [
                $this->getEntityName() => $this->repository->find($id)
            ];

            $variables = $this->getVariablesForEditView();

            return $this->response->view("{$this->getViewNamespace()}.edit", array_merge($data, $variables));
        }

        /**
         * @return array
         */
        protected function getVariablesForEditView(): array
        {
            return $this->getVariablesForPersistenceView();
        }

        /**
         * @return array
         */
        protected function getVariablesForPersistenceView(): array
        {
            return [];
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function create()
        {
            $variables = $this->getVariablesForCreateView();
            return view("{$this->getViewNamespace()}.create", $variables);
        }

        /**
         * @return null|string
         */
        public function getInitialUrlIndex(): ?string
        {
            $route         = session('old.index_url');
            $hasSoftDelete = Schema::hasColumn($this->repository->makeModel()->getTable(), 'deleted_at');

            if ( $hasSoftDelete && !strpos($route, 'deleted_at=') !== false ) {
                $route .= '?deleted_at=whereNull';
            }

            return $route;
        }

        /**
         * @return array
         */
        protected function getVariablesForCreateView(): array
        {
            return $this->getVariablesForPersistenceView();
        }

        /**
         * @return $this|\Illuminate\Http\RedirectResponse
         */
        public function store()
        {
            try {
                $this->service->create($this->getRequestDataForStoring());

                return $this->response->redirectTo($this->getInitialUrlIndex())->with('success', $this->getMessage('created'));

            } catch ( ValidatorException $e ) {
                return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
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
         * @param int $id
         *
         * @return $this|\Illuminate\Http\RedirectResponse
         */
        public function update(int $id)
        {
            try {
                $this->service->update($this->request->all(), $id);
                return $this->response->redirectTo($this->getInitialUrlIndex())->with('success', $this->getMessage('edited'));
            } catch ( ValidatorException $e ) {
                return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
            }
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show(int $id)
        {
            return $this->response->view("{$this->getViewNamespace()}.show", [
                $this->getEntityName() => $this->repository->withTrashed()->find($id)
            ]);
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function destroy(int $id)
        {
            $this->service->delete($id);
            return $this->response->redirectToRoute($this->getRouteAliasForIndexAction())->with('success', $this->getMessage('deleted'));
        }

        /**
         * Guard uri of index in cache for singleton
         *
         * @return void
         */
        protected function guardUrlIndex(): void
        {
            session(['old.index_url' => $this->request->fullUrl()]);
        }
    }