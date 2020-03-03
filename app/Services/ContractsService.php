<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Entities\Contracts;
use Delos\Dgp\Repositories\Contracts\ContractsRepositoryEloquent;

class ContractsService extends AbstractService{
    
    public function repositoryClass():string{
        return ContractsRepositoryEloquent::class;
    }

    public function delete($id){

    }

    public function create(array $data){

    }

    public function update(array $data, $id){

    }
}