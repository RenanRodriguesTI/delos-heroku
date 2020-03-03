<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Eloquent\ClientRepositoryEloquent;

class ClientService extends AbstractService
{
    public function repositoryClass() : string
    {
        return ClientRepositoryEloquent::class;
    }

    public function create(array $data)
    {
        return $this->conn->transaction(function () use($data) {
            $this->validator->with($data)->passesOrFail('create');

            if(empty($data['cod'])) {
                $client = $this->repository->findByField('group_id', $data['group_id'])->first();
                $nextCod = is_null($client) ?  1 : $client->group->clients->max('cod') + 1;
                $data['cod'] = str_pad($nextCod, 3, '0', STR_PAD_LEFT);
            }

            $rules = $this->validator->getRules('create');
            $rules['cod'] .= "|unique:clients,cod,NULL,id,group_id,{$data['group_id']}";

            $this->validator->setRules($rules);
            $this->validator->with($data)->passesOrFail('create');
            return $this->repository->create($data);
        });
    }

    public function update(array $data, $id)
    {
        //First validation is to know if group_id field exists
        $rules = $this->validator->getRules('update');
        $groupValidator = $rules['group_id'];

        $this->validator->setRules(['group_id' => $groupValidator])
            ->with($data)
            ->passesOrFail('update');

        $rules['cod'] .= "|unique:clients,cod,{$id},id,group_id,{$data['group_id']}";
        $rules['name'] .= ",name,{$id}";

        $this->validator->setRules($rules)
            ->with($data)
            ->passesOrFail('update');

        return $this->repository->update($data, $id);
    }
}