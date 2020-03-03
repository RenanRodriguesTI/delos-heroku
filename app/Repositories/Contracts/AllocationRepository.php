<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 18/04/18
 * Time: 11:42
 */

namespace Delos\Dgp\Repositories\Contracts;
use Carbon\Carbon;

/**
 * Interface AllocationRepository
 * @package Delos\Dgp\Repositories\Contracts
 */
interface AllocationRepository extends RepositoryInterface
{
    /**
     * Get possible allocations from period
     *
     * @param Carbon $start
     * @param Carbon $finish
     * @param int    $userId
     * @param array  $data
     *
     * @return mixed
     */
    public function getPossibleAllocationsFromPeriod(Carbon $start, Carbon $finish, int $userId, array $data);

    /**
     * @return array
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getAllocationsToReport();
}