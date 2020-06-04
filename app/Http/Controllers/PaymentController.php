<?php

namespace Delos\Dgp\Http\Controllers;
use Prettus\Validator\Exceptions\ValidatorException;

class PaymentController extends AbstractController
{
    public function index(){
        $this->repository->orderBy('name','asc');
        return parent::index();
    }

    public function edit(int $id){
        $paymentType = $this->repository->find($id);

        return $this->response->json([
            'paymentType' =>$paymentType
        ]);
    }
    public function store(){
        try{
            $this->service->create($this->getRequest());
            return $this->response->redirectToRoute('payment.index');
        } catch(ValidatorException $e){
            return $this->redirector->back()
            ->withErrors($e->getMessageBag())
            ->withInput();
        }
    }

    public function update(int $id)
    {
        try {
        
            $this->service->update($this->getRequest(), $id);
            return $this->response->redirectToRoute('payment.index');
        } catch ( ValidatorException $e ) {
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function getRequest(){
        $data = $this->request->all();
        if(!isset($data['ative'])){
            $data['ative'] = false;
        }
        return $data;
    }
}
