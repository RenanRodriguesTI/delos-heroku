<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\TaskRepositoryEloquent;
use Prettus\Validator\Contracts\ValidatorInterface;

class TaskService extends AbstractService
{
    public function repositoryClass() : string
    {
        return TaskRepositoryEloquent::class;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

        return $this->repository->makeModel()->create($data);
    }
}