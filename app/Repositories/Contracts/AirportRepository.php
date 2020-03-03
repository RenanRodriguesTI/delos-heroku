<?php

namespace Delos\Dgp\Repositories\Contracts;

interface AirportRepository extends RepositoryInterface
{
    public function getPairsByStateId(int $stateId) : array;
}