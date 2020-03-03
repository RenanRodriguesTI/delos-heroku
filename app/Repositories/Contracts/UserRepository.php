<?php

namespace Delos\Dgp\Repositories\Contracts;

use Illuminate\Support\Collection;


/**
 * Interface UserRepository
 * @package Delos\Dgp\Repositories\Contracts
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * @param bool $paginate
     * @param int|null $limit
     * @param array $columns
     * @return mixed
     */
    public function getCollaborators(bool $paginate = false, int $limit = null, array $columns = ['*']);

    /**
     * @param int $projectId
     * @param string $column
     * @param string|null $key
     * @return mixed
     */
    public function getPairsOfMembersProject(int $projectId, string $column, string $key = null);

    /**
     * @param int $requestId
     * @return iterable
     */
    public function getPairsByRequestId(int $requestId): iterable;

    /**
     * @param int $projectId
     * @return iterable
     */
    public function getCollaboratorsAndCoLeaderByProjectId(int $projectId): iterable;

    /**
     * @return iterable
     */
    public function getUsersHasMissingActivities(): iterable;

    /**
     * @param int $roleId
     * @return iterable
     */
    public function getByRoleId(int $roleId): iterable;

    /**
     * @param array $columns
     * @return iterable
     */
    public function getAllUsersWhoCanBeMembers(array $columns = ['*']): iterable;

    /**
     * @param int $leaderId
     * @return iterable
     */
    public function getMembersByLeaderId(int $leaderId): iterable;

    /**
     * @param int $leaderId
     * @return iterable
     */
    public function getMembersIdsByLeaderId(int $leaderId): iterable;

    /**
     * @return iterable
     */
    public function getManagers(): iterable;

    /**
     * @return Collection
     */
    public function getFromClientRole(): Collection;
}