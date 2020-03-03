<?php

    namespace Delos\Dgp\Services;

    use Delos\Dgp\Events\ApprovedRequestEvent;
    use Delos\Dgp\Events\CreatedRequestEvent;
    use Delos\Dgp\Events\RefusedRequestEvent;
    use Delos\Dgp\Repositories\Eloquent\RequestRepositoryEloquent;
    use Delos\Dgp\Services\Request\{
        Car, ChildRequest, Food, Fuel, Lodging, Other, Taxi, Ticket, Toll
    };
    use Prettus\Validator\Contracts\ValidatorInterface;

    /**
     * Class RequestService
     * @package Delos\Dgp\Services
     */
    class RequestService extends AbstractService
    {
        /**
         * @return string
         */
        public function repositoryClass(): string
        {
            return RequestRepositoryEloquent::class;
        }

        /**
         * @param array $data
         *
         * @return mixed|void
         * @throws \Throwable
         */
        public function create(array $data)
        {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $this->conn->transaction(function () use ($data) {
                
                $projectId = $data['request']['project_id'];
                $start     = $data['request']['start'];
                $finish    = $data['request']['finish'];
                $notes     = $data['request']['notes'];

                $parentRequest = $this->getParentRequest($projectId, $start, $finish, $notes);

                $parentRequest->users()->attach($data['request']['collaborators']);

                $childRequest = new ChildRequest($parentRequest);
                $childRequest = new Ticket($childRequest);
                $childRequest = new Lodging($childRequest);
                $childRequest = new Car($childRequest);
                $childRequest = new Food($childRequest);
                $childRequest = new Toll($childRequest);
                $childRequest = new Taxi($childRequest);
                $childRequest = new Other($childRequest);
                $childRequest = new Fuel($childRequest);

                $childRequest->createRequest($data);

                $request = $parentRequest->getModel()->fresh();

                $this->event->fire(new CreatedRequestEvent($request));
                return $request;
            });
        }

        /**
         * @param int $id
         *
         * @return mixed
         * @throws \Throwable
         */
        public function approve(int $id)
        {
            $request = $this->conn->transaction(function () use ($id) {
                $request = $this->repository->update(['approved' => true, 'approver_id' => \Auth::id()], $id);
                $this->event->fire(new ApprovedRequestEvent($request));
                return $request;
            });

            return $request;
        }

        /**
         * @param int    $id
         * @param string $reason
         *
         * @throws \Throwable
         */
        public function refuse(int $id, string $reason)
        {
            $this->conn->transaction(function () use ($id, $reason) {
                $request = $this->repository->update(['approved' => false, 'reason' => $reason], $id);
                $this->event->fire(new RefusedRequestEvent($request, $reason));
            });
        }

        /**
         * @param $projectId
         * @param $start
         * @param $finish
         * @param $notes
         *
         * @return mixed
         */
        private function getParentRequest($projectId, $start, $finish, $notes)
        {
            $parentRequest = $this->repository->create([   'notes'        => $notes,
                                                           'requester_id' => app('auth')->getUser()->id,
                                                           'project_id'   => $projectId,
                                                           'start'        => $start,
                                                           'finish'       => $finish
                                                       ]);
            return $parentRequest;
        }
    }