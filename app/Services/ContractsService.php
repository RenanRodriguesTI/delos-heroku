<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Entities\Contracts;
use Delos\Dgp\Repositories\Eloquent\UserRepositoryEloquent;
use Prettus\Validator\Contracts\ValidatorInterface;

class ContractsService extends AbstractService{
    
    public function repositoryClass() : string
    {
        return UserRepositoryEloquent::class;
    }

    public function delete($id){

    }

    public function create(array $data){

    }

    public function update(array $data, $id){

    }

    private function updateRulesToContracts(){
        $rules['create']['start']='required|date';
        $rules['create']['end'] = 'required|date';
        $rules['create']['value'] = 'required|numeric';
        $rules['create']['user_id'] = 'required|exists:users,id';

        $rules['update']['start'] = 'required|date';
        $rules['update']['end'] = 'required|date';
        $rules['update']['value'] = 'required|numeric';
        $rules['update']['user_id'] = 'exists:users,id';
        $this->validator->setRules($rules);
    }

    public function createContracts(array $data){
        //$this->updateRulesToContracts();
        unset($data['_token']);
        //$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
        $contracts = Contracts::create($data);
        if($data['projects'])
        $contracts->projects()->attach($this->projectAndContract($contracts->id,$data['projects']));
        return $contracts;
    }

    private function projectAndContract(int $id,array $projects){
        $projectContracts = [];
        foreach($projects as $project){
            $projectContracts[] = ['contracts_id'=>$id,'project_id' =>$project];
        }
        return  $projectContracts;
    }

    public function updateContracts(array $data, $id){
        //$this->updateRulesToContracts();
       // $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $contracts =  Contracts::find($id);
        $contracts->update($data);
        if($data['projects']){
            $contracts->projects()->detach();
            $contracts->projects()->attach($this->projectAndContract($contracts->id,$data['projects']));
        }
       
        return $contracts;
    }

    public function deleteContracts($id){
        $contract =Contracts::find($id);
        $contract->delete();

        return $contract;
    }
}