<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 24/08/17
 * Time: 10:25
 */

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\PermissionRepository;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class ModulesController extends AbstractController
{
    public function permissions(int $id)
    {
        $module = $this->repository->find($id);
        $permissions = app(PermissionRepository::class)->makeModel()->whereNotIn('id', $module->permissions()->pluck('id'))->pluck('name', 'id');

        return $this->response
            ->view("{$this->getViewNamespace()}.permissions", [
                'module' => $module,
                'permissions' => $permissions
            ]);
    }

    public function addPermission(int $id, Request $request)
    {
        $permissions = $request->input('permission_id');

        try {
            $this->service->addPermission($id, $permissions);
            return $this->response
                ->redirectToRoute('modules.permissions', ['id' => $id]);
        } catch(ValidatorException $e) {

            $response = $this->redirector
                ->back()
                ->withInput()
                ->withErrors($e->getMessageBag());

            return $response;
        }

    }

    public function removePermission(int $id, int $permissionId)
    {
        $this->service->removePermission($id, $permissionId);

        return $this->response
            ->redirectToRoute('modules.permissions', ['id' => $id]);
    }
}