<?php

    namespace Delos\Dgp\Http\Controllers;

    use Delos\Dgp\Repositories\Contracts\UserRepository;
    use Prettus\Validator\Exceptions\ValidatorException;

    /**
     * Class CoastUsersController.
     *
     * @package namespace Delos\Dgp\Http\Controllers;
     */
    class CoastUsersController extends AbstractController
    {
        protected function getVariablesForIndexView(): array
        {
            $data = [
                'users' => app(UserRepository::class)
                    ->withTrashed()
                    ->with('coasts')
                    ->orderBy('name', 'asc')
                    ->all()
            ];

            return $data;
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

            $viewName = $this->getViewNamespace() . '.index';
            $data     = $this->getVariablesForIndexView();

            return view($viewName, $data);
        }

        /**
         * @param int $id
         *
         * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
         */
        public function update(int $id)
        {
            try {
                $this->service->update($this->request->all(), $id);
                return $this->response->json('Coast User has been added');

            } catch ( ValidatorException $e ) {
                return $this->response->json($e->getMessageBag(), 401);

            }
        }

        public function copyLastValues()
        {
            $this->service->copyLastValues();
            return $this->response->redirectToRoute('coastUsers.index')
                                  ->with('success', $this->getMessage('edited'));
        }
    }
