<?php

namespace Delos\Dgp\Http\Controllers;

use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
class AppVersionsController extends AbstractController
{

    public function store()
    {
        try {
            $data = $this->request->all();
            $this->service->create($data);
            return $this->response->redirectTo($this->getInitialUrlIndex())
                                  ->with('success', $this->getMessage('created'));

        } catch ( ValidatorException $e ) {
            return $this->redirector->back()
                                    ->withErrors($e->getMessageBag())
                                    ->withInput();
        }

    }
}
