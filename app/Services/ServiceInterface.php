<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\RepositoryInterface;

interface ServiceInterface
{
    public function update(array $data, $id);

    public function delete($id);

    public function create(array $data);

    public function getRepository() : RepositoryInterface;

    public function repositoryClass() : string;

}