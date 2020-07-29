<?php

namespace Delos\Dgp\Services;

use Delos\Dgp\Repositories\Contracts\ActivityRepository;
use Delos\Dgp\Repositories\Eloquent\UserRepositoryEloquent;
use Delos\Dgp\Events\CreatedUserEvent;
use Delos\Dgp\Events\UpdateUser;
use Delos\Dgp\Exceptions\CannotRemoveUserException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Delos\Dgp\Entities\UserOffice;
use Illuminate\Validation\Rule;
use Delos\Dgp\Rules\UniqueUserOfficeHistory;

class UserService extends AbstractService
{
    public function repositoryClass() : string
    {
        return UserRepositoryEloquent::class;
    }

    public function create(array $data)
    {
         $data['start'] = isset($data['startoffice'])? $data['startoffice'] :'';
        $password = str_random(12);
        $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        $user = parent::create($data);
        UserOffice::create([
                'user_id' => $user->id,
                'office_id' =>$data['office_id'],
                'start' => $data['start'],
          ]);
        
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
        $before = $this->repository->find($id);

        $data['start'] = isset($data['startoffice'])? $data['startoffice'] :'';
        $office= app('request')->input('office_id');
        $rules['update']['start'] = ['bail','required','date_format:d/m/Y',new UniqueUserOfficeHistory($id,$before,$office)];
        $this->validator->setRules($rules);
        $this->validator->setId($id);
        $this->validator->with($data)
            ->passesOrFail(ValidatorInterface::RULE_UPDATE);

        $this->repository->update($data, $id);
        $user = $this->repository->find($id);
        event(new UpdateUser($user,$data));
        return $user;
    }
}