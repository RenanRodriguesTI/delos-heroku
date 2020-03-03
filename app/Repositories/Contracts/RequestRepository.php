<?php

namespace Delos\Dgp\Repositories\Contracts;

use Carbon\Carbon;

interface RequestRepository extends RepositoryInterface
{
    public function getRequestsByProjectId(int $projectId, bool $paginate = true, int $limit = null, array $columns = ['*']);

    public function getApprovedRequestsPairsByProjectId(int $projectId) : iterable;

    public function getPairsByDate(Carbon $date) : iterable;
}