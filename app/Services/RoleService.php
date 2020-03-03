<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\RoleRepositoryEloquent;

class RoleService extends AbstractService
{
    public function repositoryClass() : string
    {
        return RoleRepositoryEloquent::class;
    }

    public function addPermission(int $roleId, $permissions)
    {
        $this->validator->setRules([
            'permission_id.*' => "required|exists:permissions,id|unique:permission_role,permission_id,NULL,id,role_id,$roleId"
        ]);

        $this->validator
            ->with(['permission_id' => $permissions])
            ->passesOrFail();

        $this->repository->find($roleId)
            ->permissions()
            ->attach($permissions);
    }

    public function removePermission(int $roleId, int $permissionId)
    {
         $this->repository
            ->find($roleId)
            ->permissions()
            ->detach($permissionId);
    }
}