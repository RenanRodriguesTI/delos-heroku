<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/07/17
 * Time: 15:58
 */

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\PlanRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class GroupCompaniesController extends AbstractController
{
    protected function getVariablesForPersistenceView(): array
    {
        $variables = parent::getVariablesForPersistenceView();
        $variables['plans'] = app(PlanRepository::class)->pluck('name', 'id')->toArray();

        return $variables;
    }

    public function store()
    {
        try {
            $data = $this->getRequestDataForStoring();
            $data['name'] = 'Grupo ' . $data['name'];

            $this->service->create($data);

            return $this->response
                ->redirectTo($this->getInitialUrlIndex())
                ->with('success', $this->getMessage('created'));

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }
}