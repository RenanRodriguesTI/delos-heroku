<?php

namespace Delos\Dgp\Repositories\Contracts;

use Carbon\Carbon;

interface ActivityApiRepository extends RepositoryInterface
{
    public function sumApprovedHoursByProjectId(int $projectId) : int;

    public function sumApprovedHoursByUserId(int $user) : int;

    public function sumHoursByUserIdAndDate(int $userId, Carbon $date) : int;

    public function getAbsencesCreatedSinceLastMonday() : iterable;

    public function countWaitingToBeApprovedByUserId(int $userId) : int;

    public function getExternalWorksLastMonthForListing() : iterable;
}