<?php

namespace Delos\Dgp\Repositories\Contracts;

interface PermissionRepository extends RepositoryInterface
{
    public function getDiffPairsByUserId(int $userId) : iterable;

    public function getPermissionsIdsByRoleId(int $roleId) : iterable;

}