<?php

namespace Delos\Dgp\Repositories\Contracts;

interface TaskRepository extends RepositoryInterface
{
    public function getTasksPairsByProjectId(int $projectId) : iterable;
}