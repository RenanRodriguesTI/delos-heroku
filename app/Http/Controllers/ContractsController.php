<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Entities\Contracts;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Rules\StartPeriodRule;
use Delos\Dgp\Rules\NumberFormatRule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Delos\Dgp\Rules\MinValueRule;

class ContractsController extends AbstractController
{
 
    public function index(){
        //$contracts = $this->repository->with('contracts')->find($id);
        $contracts =[];
        return view('contracts.index',compact($contracts));
    }

    public function contracts(int $id){
        $messages = [
            'before' => ':attribute é menor',
            'after' => ':attribute é maior'
        ];
        $this->validate($this->request,[
            'startfilter'=>['required', 'date_format:"d/m/Y"','before:'.$this->request['endfilter']],
            'endfilter' =>['required', 'date_format:"d/m/Y"','after:'.$this->request['startfilter']],
        ], $messages);

        
        $contracts = Contracts::whereBetween('start',
        [Carbon::createFromFormat(
            'd/m/Y',
            $this->request['startfilter']
            )->format('Y-m-d'),
            Carbon::createFromFormat('d/m/Y',
            $this->request['endfilter'])->format('Y-m-d') 
            ])->orWhereBetween('end',
            [Carbon::createFromFormat(
                'd/m/Y',
                $this->request['startfilter']
                )->format('Y-m-d'),
                Carbon::createFromFormat('d/m/Y',
                $this->request['endfilter'])->format('Y-m-d') 
                ])->where('user_id',$id)->get();
            
            return $this->response->json([
                'contracts' =>$contracts
            ],($contracts)?200:404);
    }
    
    public function create(){
        $userId= 0;
        $users = User::all()->pluck('name','id');
        return view('contracts.create',compact('userId','users'));
    }

    public function store(){
        try{
          
           $this->validate($this->request, [
            'start' =>  ['required','date_format:"d/m/Y"','before:'.$this->request["end"],new StartPeriodRule($this->request['user_id'])],
            'end' =>    ['required','date_format:"d/m/Y"','after:'.$this->request["start"],new StartPeriodRule($this->request['user_id'])],
            'value' =>  ['required',new NumberFormatRule,new MinValueRule],
            'projects' =>'required',
            'user_id' =>'required'
        ]);
         $contract = $this->service->createContracts($this->request->all());
           return $this->response->json([
               "contract" =>$contract->id
           ],201);
        }
        catch(ValidationException $e){
            return $this->response([
                "errors" =>$e->getMessageBag()
            ],422);
        }
    }

    public function update(int $id){
        try{
            $this->validate($this->request, [
                'start' =>  ['required','date_format:"d/m/Y"','before:'.$this->request["end"],new StartPeriodRule($this->request['user_id'],$id)],
                'end' =>    ['required','date_format:"d/m/Y"','after:'.$this->request["start"],new StartPeriodRule($this->request['user_id'],$id)],
                'value' =>  ['required',new NumberFormatRule, new MinValueRule],
                'user_id' =>'required',
                'projects' =>'required'
            ]); 
            $contract = $this->service->updateContracts($this->getRequestDataForStoring(),$id);
            return $this->response->json([
                "contract" => $contract->id
            ],200);
        } catch(ValidationException $e){
            return $this->response()->json([
                "errors" =>$e->getMessageBag()
            ],422);
        }
       
    }

    public function delete($id){
      $deleted =  $this->service->deleteContracts($id);
      return $this->response->redirectToRoute("users.edit", ["id" => $deleted->user_id])->with('success', 'Descrição de Proposta de Valor removida com sucesso');
    }


}
