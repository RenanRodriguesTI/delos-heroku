<?php

namespace Delos\Dgp\Services;
use Delos\Dgp\Repositories\Eloquent\UserRepositoryEloquent;

class ProviderService extends AbstractService{

    public function repositoryClass() : string
    {
        return UserRepositoryEloquent::class;
    }

    public function delete($id){

    }

    public function create(array $data){

    }

    public function update(array $data, $id){

    }
}