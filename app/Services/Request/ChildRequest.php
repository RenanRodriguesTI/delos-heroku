<?php

    namespace Delos\Dgp\Services\Request;

    use Delos\Dgp\Entities\Request;

    /**
     * Class ChildRequest
     * @package Delos\Dgp\Services\Request
     */
    class ChildRequest implements RequestInterface
    {
        /**
         * @var Request
         */
        private $requestModel;

        /**
         * ChildRequest constructor.
         *
         * @param Request $requestModel
         */
        public function __construct(Request $requestModel)
        {
            $this->requestModel = $requestModel;
        }

        /**
         * @param array $data
         *
         * @return \Illuminate\Database\Eloquent\Model
         */
        public function createRequest(array $data)
        {
            $collaborators = $data['request']['collaborators'];

            $childRequest = $this->requestModel->children()->create([]);
            $childRequest->users()->attach($collaborators);

            return $childRequest;
        }

        /**
         * @return Request
         */
        public function getRequest()
        {
            return $this->requestModel;
        }
    }