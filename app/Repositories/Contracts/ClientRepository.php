<?php

namespace Delos\Dgp\Repositories\Contracts;

interface ClientRepository extends RepositoryInterface
{
    public function countByProjectId(int $projectId) : int;
}