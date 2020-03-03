<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 24/08/17
 * Time: 10:32
 */

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\ModuleRepository;

class ModuleService extends AbstractService
{
    public function repositoryClass(): string
    {
        return ModuleRepository::class;
    }

    public function addPermission(int $id, $permissions)
    {
        $this->validator->setRules([
            'permission_id.*' => "required|exists:permissions,id|unique:module_permission,permission_id,NULL,id,module_id,$id"
        ]);

        $this->validator->with(['permission_id' => $permissions])->passesOrFail();

        $this->repository->find($id)
            ->permissions()
            ->attach($permissions);
    }

    public function removePermission(int $id, int $permissionId)
    {
        $this->repository
            ->find($id)
            ->permissions()
            ->detach($permissionId);

    }
}