<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\EpiRepository;
use Delos\Dgp\Events\EpisUploadedFile;
use Delos\Dgp\Validators\EpiValidator;
use Delos\Dgp\Repositories\Contracts\EpiUserRepository;
use Prettus\Validator\Contracts\ValidatorInterface;

class EpisService extends AbstractService
{
    public function repositoryClass(): string
    {
        return EpiRepository::class;
    }

    public function create(array $data)
    {
        $epi = parent::create($data);

        if ($this->isUpload($data)) {
            $this->event->fire(new EpisUploadedFile($epi));
        }


        return $epi;
    }

    public function update(array $data, $id)
    {
        $rules['update']['name'] = 'required|unique:epis,name,' . $id.',id,deleted_at,NULL';
        // $rules['update']['ca'] = 'numeric';
        // $rules['update']['shelf_life'] = 'required|date_format:d/m/Y';
        // $rules['update']['user_id'] = 'exists:users,id';
        $this->validator->setRules($rules);
        $epi = parent::update($data, $id);


      




        return $epi;
    }

    private function isUpload(array $data): bool
    {
        return array_key_exists('file', $data) && !empty($data['file']);
    }

    public function withdraw(array $data){
        $rules['create']['name'] = 'required';
        $rules['create']['ca'] = 'numeric';
        $rules['create']['shelf_life'] = 'required|date_format:d/m/Y';
        $rules['create']['user_id'] = 'exists:users,id';
        $this->validator->setRules($rules);
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

        $epi = $this->repository->findWhere(['name'=>$data['name']])->first();

        if(!$epi){
          $epi =   $this->repository->create(['name'=>$data['name']]);
          
        }
        $data['epi_id'] = $epi->id;

        $epiUser = app(EpiUserRepository::class)->findWhere(['user_id'=>$data['user_id'],'epi_id'=>$data['epi_id']])->first();
        if($epiUser){
            unset($data['id']);
            $epiUser->update($data);
        } else{
            unset($data['id']);
            $epiUser = app(EpiUserRepository::class)->create($data);
        }
       

        if ($this->isUpload($data)) {
            $this->event->fire(new EpisUploadedFile($epiUser));
        }

        return $epiUser;
    }

    public function updateEpiUser(array $data,$id){

    }
}
