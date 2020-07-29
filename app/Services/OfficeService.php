<?php
namespace Delos\Dgp\Services;
use Delos\Dgp\Repositories\Eloquent\OfficeRepositoryEloquent;
use Delos\Dgp\Events\SavedOffice;
use Delos\Dgp\Events\UpdatedOffice;
use Prettus\Validator\Contracts\ValidatorInterface;
use Delos\Dgp\Entities\OfficeHistory;

class OfficeService extends AbstractService{
    public function repositoryClass():string{
        return OfficeRepositoryEloquent::class;
    }

    public function create(array $data){
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
        $office = $this->repository->create($data);

        event(new SavedOffice($office));

        return  $office;
    }

    public function update(array $data,$id){
        $rules['update']['name'] = 'required|unique:offices,name,'.$id;
        $this->validator->setRules($rules);
        $this->validator->setId($id);
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $office= $this->repository->update($data,$id);
        //event(new UpdatedOffice($office));
        return $office;
    }

    public function storeHistory(array $data,$id){
       return OfficeHistory::create([
            'value' => $data['value'],
            'start' => $data['start'],
            'finish' => $data['finish'],
            'office_id' => $id
        ]);
    }

    public function updateHistory(array $data,$id){
        $last =  OfficeHistory::where('office_id',$id)->whereNull('finish')->get()->first();

        if($last){
            $last->finish = $data['finishupdate'];
            $last->save();
        }

        return null;
    }
    
    public function deleteHistory(int $id){
       return OfficeHistory::destroy($id);
    }
}