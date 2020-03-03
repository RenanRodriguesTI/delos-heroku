<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 22/08/17
 * Time: 15:12
 */

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\PlanRepository;

class PlanService extends AbstractService
{
    public function repositoryClass(): string
    {
        return PlanRepository::class;
    }

    public function addModules(int $id, $permissions)
    {
        $this->validator->setRules([
            'module_id.*' => "required|exists:modules,id|unique:module_plan,module_id,NULL,id,plan_id,{$id}"
        ]);

        $this->validator->with(['module_id' => $permissions])->passesOrFail();

        $this->repository->find($id)
            ->modules()
            ->attach($permissions);
    }

    public function removeModule(int $id, int $permissionId)
    {
        $this->repository
            ->find($id)
            ->modules()
            ->detach($permissionId);

    }
}