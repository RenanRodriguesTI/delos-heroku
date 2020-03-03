<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;
use Prettus\Validator\Exceptions\ValidatorException;

class GroupsController extends AbstractController
{
    public function getVariablesForPersistenceView() : array
    {
        return [
            'groupCompanies' => app(GroupCompanyRepository::class)->pluck('name', 'id')
        ];
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

        } catch(\RangeException $e) {
            $message = trans("exception-messages.{$e->getMessage()}");
            return $this->redirector
                ->back()
                ->withErrors(['cod' => $message])
                ->withInput();
        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }
    }
}