<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Entities\Permission;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class RolesController extends AbstractController
{

    public function permissions(int $roleId, Permission $permission)
    {
        $role = $this->repository->find($roleId);
        $rolePermissions = $role->permissions;

        $permissions = $permission->all()->reject(function ($value, $key) use ($rolePermissions) {
            return $rolePermissions->contains($value);            
        })->pluck('name', 'id');

        return $this->response
            ->view("{$this->getViewNamespace()}.permissions", [
                'role' => $role,
                'permissions' => $permissions
        ]);
    }

    public function addPermission(int $roleId, Request $request)
    {
        $permissions = $request->input('permission_id');

        try {
            $this->service->addPermission($roleId, $permissions);
            return $this->response
                ->redirectToRoute('roles.permissions', ['id' => $roleId]);
        } catch(ValidatorException $e) {

            $response = $this->redirector
                ->back()
                ->withInput()
                ->withErrors($e->getMessageBag());

            return $response;
        }

    }

    public function removePermission(int $roleId, int $permissionId)
    {
        $this->service->removePermission($roleId, $permissionId);

        return $this->response
            ->redirectToRoute('roles.permissions', ['id' => $roleId]);
    }
}
