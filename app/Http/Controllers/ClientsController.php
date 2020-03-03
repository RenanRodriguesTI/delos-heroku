<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Delos\Dgp\Repositories\Contracts\GroupRepository;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientsController extends AbstractController
{
    protected function getVariablesForPersistenceView(): array
    {
        return [
            'groups' => app(GroupRepository::class)->pluck('name', 'id'),
            'groupCompanies' => app(GroupCompanyRepository::class)->pluck('name', 'id')
        ];
    }

    public function byGroup($groupId, Request $request)
    {
        $clients = $this->repository
            ->findByField('group_id', $groupId)
            ->pluck('name', 'id');

        if($request->wantsJson()) {

            return $this->response->json($clients);
        }

        return $clients;
    }

    public function destroy(int $id)
    {
        if ($this->repository->find($id)->projects->first()) {
            return $this->redirector
                ->back()
                ->withErrors(['clients' => trans('exception-messages.clients')])
                ->withInput();
        }

        $this->service->delete($id);
        return $this->response
            ->redirectTo($this->getInitialUrlIndex())
            ->with('success', $this->getMessage('deleted'));
    }

    public function store()
    {
        try {
            $data = $this->getRequestDataForStoring();

            if (!$this->request->get('group_company_id')) {
                $data['group_company_id'] = \Auth::user()->group_company_id;
            }

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
