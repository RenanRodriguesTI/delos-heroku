<?php

    namespace Delos\Dgp\Services\Api;

    use Delos\Dgp\Services\ServiceInterface;
    use Delos\Dgp\Repositories\Contracts\RepositoryInterface;
    use Illuminate\Events\Dispatcher as Event;
    use Prettus\Validator\Contracts\ValidatorInterface;
    use Illuminate\Database\ConnectionInterface as Connection;

    /**
     * Class AbstractService
     * @package Delos\Dgp\Services
     */
    abstract class AbstractService implements ServiceInterface
    {
        /**
         * @var ValidatorInterface
         */
        protected $validator;

        /**
         * @var Event
         */
        protected $event;

        /**
         * @var Connection
         */
        protected $conn;

        /**
         * @var RepositoryInterface
         */
        protected $repository;

        /**
         * AbstractService constructor.
         *
         * @param ValidatorInterface $validator
         * @param Event              $event
         * @param Connection         $conn
         */
        public function __construct(ValidatorInterface $validator, Event $event, Connection $conn)
        {
            $this->validator  = $validator;
            $this->event      = $event;
            $this->conn       = $conn;
            $this->repository = $this->makeRepository();
        }

        /**
         * @return \Illuminate\Foundation\Application|mixed
         */
        private function makeRepository()
        {
            return app($this->repositoryClass());
        }

        /**
         * @param array $data
         *
         * @return mixed
         * @throws \Prettus\Validator\Exceptions\ValidatorException
         */
        public function create(array $data)
        {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

            return $this->repository->create($data);
        }

        /**
         * @param array $data
         * @param       $id
         *
         * @return mixed
         * @throws \Prettus\Validator\Exceptions\ValidatorException
         */
        public function update(array $data, $id)
        {
            $this->validator->setId($id);
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

            return $this->repository->update($data, $id);
        }

        /**
         * @param $id
         *
         * @return int
         */
        public function delete($id)
        {
            return $this->repository->delete($id);
        }

        /**
         * @return RepositoryInterface
         */
        public function getRepository(): RepositoryInterface
        {
            return $this->repository;
        }
    }