<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 22/08/17
 * Time: 15:06
 */

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\ModuleRepository;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PlansController extends AbstractController
{
    public function modules(int $id)
    {
        $plan = $this->repository->find($id);
        $modules = app(ModuleRepository::class)->makeModel()->whereNotIn('id', $plan->modules()->pluck('id'))->pluck('name', 'id');

        return view('plans.modules', compact('plan', 'modules'));
    }

    public function addModules(int $id, Request $request)
    {
        $modules = $request->input('module_id');

        try {
            $this->service->addModules($id, $modules);
            return $this->response
                ->redirectToRoute('plans.modules', ['id' => $id]);
        } catch(ValidatorException $e) {

            $response = $this->redirector
                ->back()
                ->withInput()
                ->withErrors($e->getMessageBag());

            return $response;
        }

    }

    public function removeModule(int $id, int $moduleId)
    {
        $this->service->removeModule($id, $moduleId);

        return $this->response
            ->redirectToRoute('plans.modules', ['id' => $id]);
    }
}