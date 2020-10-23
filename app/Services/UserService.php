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
use Delos\Dgp\Services\RangeTrait;
use Delos\Dgp\Services\WorkingDay;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Delos\Dgp\Entities\Resource;

class UserService extends AbstractService
{

    use RangeTrait, WorkingDay;

    public function repositoryClass(): string
    {
        return UserRepositoryEloquent::class;
    }

    public function create(array $data)
    {
        $data['start'] = isset($data['startoffice']) ? $data['startoffice'] : '';
        $password = str_random(12);
        $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        $user = parent::create($data);
        UserOffice::create([
            'user_id' => $user->id,
            'office_id' => $data['office_id'],
            'start' => $data['start'],
        ]);

        $this->event->fire(new CreatedUserEvent($user, $password));
        return $user;
    }

    public function delete($id)
    {
        $user = $this->repository->find($id);

        $count = $user
            ->projects->filter(function ($project) use ($user) {
                return $user->isOwnerOrCoOwner($project->id);
            })
            ->count();

        if ($count > 0) {
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

        $data['start'] = isset($data['startoffice']) ? $data['startoffice'] : '';
        $office = app('request')->input('office_id');
        $rules['update']['start'] = ['bail', 'required', 'date_format:d/m/Y', new UniqueUserOfficeHistory($id, $before, $office)];
        $this->validator->setRules($rules);
        $this->validator->setId($id);
        $this->validator->with($data)
            ->passesOrFail(ValidatorInterface::RULE_UPDATE);

        $this->repository->update($data, $id);
        $user = $this->repository->find($id);
        event(new UpdateUser($user, $data));
        return $user;
    }

    public function resources()
    {
        $this->repository->all();
    }


    private function countWorkDays(array $data): int
    {
        $quantity   = 0;
        $diffInDays = $this->getDateRange($data['start'], $data['finish']);
        foreach ($diffInDays as $day) {
            if ($this->isWorkingDay($day)) {
                $quantity++;
            }
        }
        return $quantity;
    }

    // public function getResourceSituation(array $data, $userId)
    // {
    //     $allocations = DB::select("SELECT *
    //     FROM allocations 
    //     where user_id = :userId 
    //     and parent_id is not null and 
    //     deleted_at is null and 
    //     start >= STR_TO_DATE(:start,'%d/%m/%y') 
    //     and finish<= STR_TO_DATE(:finish,'%d/%m/%y')", [
    //         'start' => $data["start"],
    //         'finish' => $data["finish"],
    //         'userId' => $userId
    //     ]);

    //     $hoursPreview = 8 * $this->countWorkDays($data);
    //     $sumHoursTask = 0;

    //     $allocationsTasks = DB::select("SELECT hours,start,finish,allocation_id 
    //         FROM allocation_tasks WHERE allocation_id in (
    //             SELECT parent_id
    //             FROM allocations 
    //             where user_id = :userId
    //             and parent_id is not null and 
    //             deleted_at is null and 
    //             start >= STR_TO_DATE(:start,'%d/%m/%y') 
    //             and finish <=  STR_TO_DATE(:finish,'%d/%m/%y')) and start is not null and finish is not null", [
    //         'start' => $data["start"],
    //         'finish' => $data["finish"],
    //         'userId' => $userId
    //     ]);



    //     foreach ($allocations as $allocation) {

    //         foreach ($allocationsTasks as $task) {

    //             $total = (int)$task->hours;
    //             $hourDay = ceil(((int)$task->hours) / $this->countWorkDays([
    //                 'start' => Carbon::createFromFormat('Y-m-d', $task->start)->format('d/m/Y'),
    //                 'finish' => Carbon::createFromFormat('Y-m-d', $task->finish)->format('d/m/Y')
    //             ]));
    //             $diffInDays    = $this->getDateRange(Carbon::createFromFormat('Y-m-d', $task->start)->format('d/m/Y'), Carbon::createFromFormat('Y-m-d', $task->finish)->format('d/m/Y'));
    //             foreach ($diffInDays as $day) {
    //                 if (Carbon::createFromFormat('d/m/Y', $day->format('d/m/Y'))->equalTo(Carbon::createFromFormat('Y-m-d', $allocation->start)) && $allocation->parent_id == $task->allocation_id) {

    //                     if (($total - $hourDay) < 0) {
    //                         $hourDay = 0;
    //                         $total = 0;
    //                     } else {
    //                         $total -= $hourDay;
    //                     }

    //                     $sumHoursTask += $hourDay;
    //                 }
    //             }
    //         }
    //     }


    //     if ($sumHoursTask == 0) {
    //         return "available";
    //     }

    //     if ($hoursPreview > $sumHoursTask) {
    //         return "partial";
    //     }

    //     if ($hoursPreview < $sumHoursTask) {
    //         return "unavailable";
    //     }
    // }

    public function getResourceSituation(array $data, $userId){
        $hoursPreview = 8 * $this->countWorkDays($data);

        $resourceHours = DB::select("SELECT COALESCE(SUM(hours),0) as hours 
                        FROM resources 
                        where start between :start and :finish and user_id =:user", 
                        [
                            'start'=>$data['start'],
                            'finish'=>$data['finish'],
                            'user' =>$userId
                        ]);

        if($resourceHours ==0){
            return "avaliable";
        } else{
            if($resourceHours <$hoursPreview){
                return "partial";
            } else{
                return  "unavaliable";
            }
        }

        
    }

    public function resource(int $id, array $data)
    {
        $history = [];
        $projects = DB::SELECT("SELECT projects.id,projects.compiled_cod,projects.description FROM allocation_tasks
        JOIN allocations on allocation_tasks.allocation_id = allocations.id
        JOIN projects on projects.id = allocations.project_id 
        where allocation_id in (SELECT ID FROM allocations WHERE parent_id is null and user_id =:user) 
        and allocation_tasks.start >= STR_TO_DATE(:start,'%d/%m/%y') 
        and allocation_tasks.finish <= STR_TO_DATE(:finish,'%d/%m/%y') group by projects.compiled_cod",[
            'start' => $data['start'],
            'finish' => $data['finish'],
            'user' => $id
        ]);

        foreach($projects as $project){
          $project->tasks = DB::select("
          SELECT allocations.user_id,tasks.name,allocation_tasks.start,allocation_tasks.finish,allocation_tasks.hours FROM allocation_tasks
          JOIN allocations on allocation_tasks.allocation_id = allocations.id 
          JOIN tasks on tasks.id = allocation_tasks.task_id
          WHERE allocation_id in (SELECT ID FROM allocations WHERE parent_id is null and user_id = :user and project_id = :project)
          and allocation_tasks.start >= STR_TO_DATE(:start,'%d/%m/%y') and allocation_tasks.finish <= STR_TO_DATE(:finish,'%d/%m/%y') 
          order by allocation_tasks.finish desc", 
          [
              'start' => $data['start'],
              'finish' => $data['finish'],
              'user' => $id,
              'project'=>$project->id
          ]);

          $history[] = $project;
        }

        

        return $history;
    }
}
