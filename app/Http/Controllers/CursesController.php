<?php

namespace Delos\Dgp\Http\Controllers;

use Prettus\Validator\Exceptions\ValidatorException;

class CursesController extends AbstractController
{
    public function store()
    {
        try {
            $curse = $this->service->create($this->getRequestDataForStoring());

            if ($this->request->wantsJson()) {
                return $this->response->json(['curse' => $curse]);
            }
            return $this->response->redirectToRoute('documents.list', ['user' => $curse->user_id, 'curses' => 1])->with('success', $this->getMessage('created'));
        } catch (ValidatorException $e) {
            if ($this->request->wantsJson()) {
                return $this->response->json($e->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function update(int $id)
    {
        try {
            $curse = $this->service->update($this->request->all(), $id);
            if ($this->request->wantsJson()) {
                return $this->response->json(['curse' => $curse]);
            }
            return $this->response->redirectToRoute('documents.list', ['user' => $curse->user_id, 'curses' => 1])->with('success', $this->getMessage('edited'));
        } catch (ValidatorException $e) {
            if ($this->request->wantsJson()) {
                return $this->response->json($e->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function destroy(int $id)
    {
        $curse = $this->repository->find($id);
        $this->service->delete($id);

        if($this->request->wantsJson()){
            return $this->response->json(['curse'=>$curse]);
        }
        return $this->response->redirectToRoute('documents.list', ['user' => $curse->user_id, 'curses' => 1])->with('success', $this->getMessage('deleted'));
    }
}
