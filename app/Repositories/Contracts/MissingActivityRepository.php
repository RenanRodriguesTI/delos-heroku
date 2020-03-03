<?php

namespace Delos\Dgp\Repositories\Contracts;

interface MissingActivityRepository extends RepositoryInterface
{
    public function sumHoursByUserId(int $userId) : int;

    public function countHoursByUserId(int $userId) : int;
}