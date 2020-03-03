<?php

namespace Delos\Dgp\Http\Controllers;

class AuditsController extends AbstractController
{
    public function index()
    {
        $this->repository->all();
        
        return parent::index();
    }

    public function show(int $id)
    {
        $data = $this->repository
                    ->skipPresenter(false)
                    ->skipCriteria(true)
                    ->find($id);

        return $this->response
                    ->view(
                        "{$this->getViewNamespace()}.show",
                        [$this->getEntityName() => $data]
                    );
    }
}