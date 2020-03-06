<?php

namespace Delos\Dgp\Http\Controllers;

use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Delos\Dgp\Entities\User;
class ContractsController extends AbstractController
{
 
    public function index(){
        $contracts = $this->repository->with('contracts')->find(0);
        return view('contracts.index',compact($contracts));
    }
    
    public function create(){
        $userId= 0;
        $users = User::all()->pluck('name','id');
        return view('contracts.create',compact('userId','users'));
    }

    public function storeContracts(){
        try{
            $this->service->createContracts([]);
            return $this->response->redirectToRoute('users.edit', ['id' => 70])->with('success', 'Contrato adicionado com sucesso');
        }
        catch(ValidationException $e){
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function update(int $id){
        $contract = $this->service->updateContracts($this->getRequestDataForStoring(),$id);
        return $this->response->redirectToRoute('users.edit', ['id' => $contract->user_id])->with('success', 'Contrato Atualizado com sucesso');
    }

    public function delete($id){
      $deleted =  $this->service->deleteContracts($id);
      return $this->response->redirectToRoute("users.edit", ["id" => $deleted->user_id])->with('success', 'Descrição de Proposta de Valor removida com sucesso');
    }


}
