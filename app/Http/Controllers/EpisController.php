<?php

namespace Delos\Dgp\Http\Controllers;

use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class EpisController.
 *
 * @package namespace Delos\Dgp\Http\Controllers;
 */
class EpisController extends AbstractController
{

    public function index(){

        $user = $this->request->input('userId');
      

        if( $user){
            $epis = $this->repository->getEpiUser($user);
        } else{
            $epis = $this->repository->all();
        }

        return $this->response->json($epis, $epis->isEmpty() ? 404:200);
    }

  

    public function store()
    {
        try {
            $epis = $this->service->create($this->getRequestDataForStoring());

            if ($this->request->wantsJson()) {
                return $this->response->json(['epis' => $epis]);
            }
            return $this->response->redirectToRoute('epis.index')->with('success', $this->getMessage('created'));
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
            $epis = $this->service->update($this->request->all(), $id);
            if ($this->request->wantsJson()) {
                return $this->response->json(['epis' => $epis]);
            }
            return $this->response->redirectToRoute('epis.index')->with('success', $this->getMessage('edited'));
        } catch (ValidatorException $e) {
            if ($this->request->wantsJson()) {
                return $this->response->json($e->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    public function destroy(int $id)
    {
        $epi = $this->repository->find($id);

        $this->service->delete($id);

        if($this->request->wantsJson()){
            return $this->response->json(['epi'=>$epi]);
        }
        return $this->response->redirectToRoute('documents.list', ['user' => $epi->user_id,'epis'=>1])->with('success', $this->getMessage('deleted'));
    }


    public function withdraw(){
        try {
            $epis = $this->service->withdraw($this->getRequestDataForStoring());

            if ($this->request->wantsJson()) {
                return $this->response->json(['epis' => $epis]);
            }
            return $this->response->redirectToRoute('epis.index')->with('success', $this->getMessage('created'));
        } catch (ValidatorException $e) {
            if ($this->request->wantsJson()) {
                return $this->response->json($e->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function updateEpiUser(int $id)
    {
        try {
            $epis = $this->service->updateEpiUser($this->request->all(), $id);
            if ($this->request->wantsJson()) {
                return $this->response->json(['epis' => $epis]);
            }
            return $this->response->redirectToRoute('epis.index')->with('success', $this->getMessage('edited'));
        } catch (ValidatorException $e) {
            if ($this->request->wantsJson()) {
                return $this->response->json($e->getMessageBag(), 422);
            }
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
