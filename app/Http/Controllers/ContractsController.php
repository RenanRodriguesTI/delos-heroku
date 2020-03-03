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

    public function store(){
        try{
            $this->service->createContracts([]);
            return $this->response->redirectToRoute('contracts.index', ['id' => $id])->with('success', 'Contrato adicionado com sucesso');
        }
        catch(ValidationException $e){
            return $this->redirector->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    //deletar contrato
    public function delete($id){
        $this->service->deleteContracts($id);
        return $this->response->redirectToRoute("contracts.index", ["id" => $projectId])->with('success', 'Descrição de Proposta de Valor removida com sucesso');
    }


}
