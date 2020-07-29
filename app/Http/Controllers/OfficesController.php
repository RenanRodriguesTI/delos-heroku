<?php

namespace Delos\Dgp\Http\Controllers;
use Delos\Dgp\Rules\OfficePeriodRule;
use Delos\Dgp\Entities\OfficeHistory;
use Prettus\Validator\Exceptions\ValidatorException;

class OfficesController extends AbstractController
{

    public function index(){
        $this->repository->orderBy('name');
        return parent::index();
    }

    public function store(){
        return parent::store();
    }

    public function edit(int $id)
    {
        $data = [
            $this->getEntityName() => $this->repository->find($id),
            'lastHistory' => OfficeHistory::where('office_id',$id)->whereNull('finish')->get()
        ];

        $variables = $this->getVariablesForEditView();

        return $this->response->view("{$this->getViewNamespace()}.edit", array_merge($data, $variables));
    }

    public function update(int $id){
        if($this->request->wantsJson()){
            return $this->updateAjax($id);
        }

        return parent::update($id);
    }

    public function updateAjax(int $id){
        try {
            $this->service->update($this->request->all(), $id);
            return $this->response->json(['update office']);
        } catch ( ValidatorException $e ) {
            return $this->response->json($e->getMessageBag(),422);
        }
    }

    public function storeHistory(int $id){

        $this->request->validate([
            'start' => ['required','date_format:d/m/Y', new OfficePeriodRule($id)],
            'finish' => ['date_format:d/m/Y', new OfficePeriodRule($id)]
        ]);
        $this->service->storeHistory($this->request->all(),$id);

        return $this->redirector->route('office.edit',['id'=>$id]);
    }

    public function updateHistory(int $id){
        $value = is_numeric($this->request->input('idhistory')) ? $this->request->input('idhistory'):0;
        $this->request->validate([
            'finishupdate' => ['required','date_format:d/m/Y', new OfficePeriodRule($id,$value)]
        ]);
        $this->service->updateHistory($this->request->all(),$id);

        return $this->redirector->route('office.edit',['id'=>$id]);
    }

    public function deleteHistory(int $id,int $idhistory){
        $this->service->deleteHistory($id);
        return $this->redirector->route('office.edit',['id'=>$idhistory]);
    }

}
