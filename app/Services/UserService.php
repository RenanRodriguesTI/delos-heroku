<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\ActivityRepository;
use Delos\Dgp\Repositories\Eloquent\UserRepositoryEloquent;
use Delos\Dgp\Events\CreatedUserEvent;
use Delos\Dgp\Exceptions\CannotRemoveUserException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Delos\Dgp\Entities\Contracts;

class UserService extends AbstractService
{
    public function repositoryClass() : string
    {
        return UserRepositoryEloquent::class;
    }

    public function create(array $data)
    {
        $password = str_random(12);
        $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        $user = parent::create($data);
        $this->event->fire(new CreatedUserEvent($user, $password));
        return $user;
    }

    public function delete($id)
    {
        $user = $this->repository->find($id);

        $count = $user
            ->projects->filter(function ($project) use($user) {
                return $user->isOwnerOrCoOwner($project->id);
            })
            ->count();

        if($count > 0) {
            throw new CannotRemoveUserException('Cannot disabled this user because it is a owner or co-owner of some project(s)');
        }

        $amountOfActivitiesWaitingToBeApproved = app(ActivityRepository::class)
            ->countWaitingToBeApprovedByUserId($id);

        if ($amountOfActivitiesWaitingToBeApproved > 0) {
            throw new CannotRemoveUserException('The user still has hours to be approved');
        }

        return parent::delete($id);
    }

    public function update(array $data, $id)
    {
        $this->validator->setId($id);
        $this->validator->with($data)
            ->passesOrFail(ValidatorInterface::RULE_UPDATE);

        $this->repository->update($data, $id);

        $user = $this->repository->find($id);
        return $user;
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
        $this->updateRulesToContracts();
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $contracts = Contracts::save($data);
        return $contracts;
    }

    public function updateContracts(array $data, $id){
        $this->updateRulesToContracts();
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $contracts =  Contracts::find($id);
        $contracts->update($data);
        return $contracts;
    }

    public function deleteContracts($id){
        Contracts::delete($id);
    }
}