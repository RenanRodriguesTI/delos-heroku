<?php

    namespace Delos\Dgp\Repositories\Contracts;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Collection;

    /**
     * Interface ProjectRepository
     * @package Delos\Dgp\Repositories\Contracts
     */
    interface ProjectRepository extends RepositoryInterface
    {
        /**
         * @param bool $applyWithTrashed
         *
         * @return array
         */
        public function getPairs($applyWithTrashed = true): array;

        public function getPairsByExtension($applyWithTrashed = true): array;

        /**
         * @return array
         */
        public function getPairsDisabled(): array;

        /**
         * @param array $membersIds
         * @param int   $projectId
         */
        public function attachMembers(array $membersIds, int $projectId): void;

        /**
         * @param int $memberId
         * @param int $projectId
         */
        public function detachMember(int $memberId, int $projectId): void;

        /**
         * @param int    $clientId
         * @param Carbon $year
         *
         * @return string
         */
        public function getLastClientCodeByClientIdAndYear(int $clientId, Carbon $year): string;

        /**
         * @param int    $groupId
         * @param Carbon $year
         *
         * @return string
         */
        public function getLastGroupCodeByGroupIdAndYear(int $groupId, Carbon $year): string;

        /**
         * @param Carbon $date
         *
         * @return iterable
         */
        public function getPairsByDate(Carbon $date): iterable;

        public function getAvaliableProposalValues(int $id);
    }