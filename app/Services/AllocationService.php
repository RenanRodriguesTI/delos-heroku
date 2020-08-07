<?php

/**
 * Created by PhpStorm.
 * User: allan
 * Date: 18/04/18
 * Time: 11:46
 */

namespace Delos\Dgp\Services;

use Carbon\Carbon;
use Delos\Dgp\Entities\Allocation;
use Delos\Dgp\Entities\AllocationTask;
use Delos\Dgp\Events\DeletedAllocation;
use Delos\Dgp\Events\SavedAllocation;
// use Delos\Dgp\Events\NotifyToPaPAllocations;
use Delos\Dgp\Repositories\Contracts\ProjectRepository;
use Delos\Dgp\Repositories\Eloquent\AllocationRepositoryEloquent;
use Prettus\Validator\Contracts\ValidatorInterface;
use Delos\Dgp\Repositories\Contracts\TaskRepository;

/**
 * Class AllocationService
 * @package Delos\Dgp\Services
 */
class AllocationService extends AbstractService
{
    use WorkingDay, RangeTrait;

    /**
     * @param array $data
     *
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(array $data)
    {
        $data['jobWeekEnd'] = isset($data['jobWeekEnd']);
        if (app('auth')->getUser()->name === 'ANA CAROLINA CALVETI' || app('auth')->getUser()->name === "VERONICA SALVATI") {
            //    if(!$data['task_id']){
            //     unset($data['task_id']);
            //    }

            $this->changevalidation();
        }

        if (isset($data['task_id']) && !$data['task_id']) {
            unset($data['task_id']);
            $this->changevalidation();
        }

        $this->addValidationToDates($data);
        $this->addValidationToHours($data);

        $data['group_company_id'] = \Auth::user()->groupCompany->id;

        $this->validator->with($data)
            ->passesOrFail(ValidatorInterface::RULE_CREATE);


        $allocationFather  = $this->repository->create($data);
        $allocations       = collect();
        $data['parent_id'] = $allocationFather->id;
        $total = $data['hours'];
        $remain = 0;
        $calculed = 0;
        \DB::transaction(function () use ($data, $allocations, $total, $remain, $calculed) {
            $diffInDays    = $this->getDateRange($data['start'], $data['finish']);
            if ($this->countWorkDays($data) > 0) {
                $remain =  ($data['hours'] % $this->countWorkDays($data));
                $calculed = (int)($data['hours'] / $this->countWorkDays($data));
                $total = $data['hours'] - $remain;
                $data['hours'] =  $calculed;
            }
            $exceptionWorkDays = $data['jobWeekEnd'];

            $workDays = $this->countWorkDays($data);
            foreach ($diffInDays as $day) {
                $data['start']  = $day->format('d/m/Y');
                $data['finish'] = $day->format('d/m/Y');

                if ($this->isWorkingDay($day, $exceptionWorkDays)) {
                    $workDays--;
                    if ($workDays == 0) {
                        $data['hours'] += $remain;
                    } else {
                        if ($total > 0) {
                            $total -= $calculed;
                        } else {
                            $data['hours'] = 0;
                        }
                    }

                    $allocation = $this->repository->create($data);
                    $allocations->push($allocation);
                }
            }
        });
        $this->fireEvent($data);

        return $allocations;
    }

    public function update(array $data, $id)
    {
        $data['jobWeekEnd'] = isset($data['jobWeekEnd']);
        $this->validator->setId($id);
        $allocations = collect();

        if (isset($data['task_id'])) {
            unset($data['task_id']);
            $this->changevalidation();
        }
        if (app('auth')->getUser()->name === 'ANA CAROLINA CALVETI' || app('auth')->getUser()->name === "VERONICA SALVATI") {
            $this->changevalidation();
        } else {
            $this->addHoursLimitValidate($id);
        }
        $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $beforeFaterAllocation = $this->repository->find($id);
        $faterAllocation = $this->repository->update($data, $id);
        $data['parent_id'] = $faterAllocation->id;
        $remain = 0;
        $calculed = 0;
        $total = $data['hours'];
        if ($faterAllocation) {

            $childAllocations = $this->repository->findWhere(['parent_id' => $id]);
            \DB::transaction(function () use ($childAllocations, $data, $allocations, $total, $calculed, $remain) {
                foreach ($childAllocations as $allocation) {
                    $allocation->forceDelete();
                }
                $diffInDays    = $this->getDateRange($data['start'], $data['finish']);

                if ($this->countWorkDays($data) > 0) {
                    $remain =  ($data['hours'] % $this->countWorkDays($data));
                    $calculed = (int)($data['hours'] / $this->countWorkDays($data));
                    $data['hours'] =  $calculed;
                }

                $exceptionWorkDays = $data['jobWeekEnd'];
                $workDays = $this->countWorkDays($data);
                foreach ($diffInDays as $day) {
                    $data['start']  = $day->format('d/m/Y');
                    $data['finish'] = $day->format('d/m/Y');

                    if ($this->isWorkingDay($day, $exceptionWorkDays)) {
                        $workDays--;
                        if ($workDays == 0) {
                            $data['hours'] += $remain;
                        } else {
                            if ($total > 0) {
                                $total -= $calculed;
                            } else {
                                $data['hours'] = 0;
                            }
                        }

                        $allocation = $this->repository->create($data);
                        $allocations->push($allocation);
                    }
                }
            });
        }
        //    if((!$beforeFaterAllocation->task && $faterAllocation->task) || (!$beforeFaterAllocation->hours != $faterAllocation->hours)){
        //         if(\Auth::user()->name != 'ANA CAROLINA CALVETI'){
        //             $allocation = new Allocation($data);    
        //             $this->event->fire( new NotifyToPaPAllocations($allocation));
        //         }    
        //    }
        $this->fireEvent($data);
        return $allocations;
    }


    /**
     * @param array $data
     */
    private function addValidationToDates(array $data): void
    {
        $project = app(ProjectRepository::class)->find($data['project_id']);
        $rules   = $this->validator->getRules();

        $rules['create']['start']  .= '|after_or_equal:' . $project->start->format('d/m/Y');
        $rules['update']['start']  .= '|after_or_equal:' . $project->start->format('d/m/Y');
        $rules['create']['finish'] .= '|before_or_equal:' . (!$project->extension ? $project->finish->format('d/m/Y') : $project->extension->format('d/m/Y'));
        $rules['update']['finish'] .= '|before_or_equal:' . (!$project->extension ? $project->finish->format('d/m/Y') : $project->extension->format('d/m/Y'));

        $this->validator->setRules($rules);
    }

    /**
     * Add max quantity hours according with period
     *
     * @param $data
     */
    private function addValidationToHours($data): void
    {
        $actualHours = $this->getActualHours($data);
        $rules       = $this->validator->getRules();
        $max         = iterator_count($this->getDateRange($data['start'], $data['finish'])) * 24 - $actualHours;

        $rules['create']['hours'] .= '|max:' . $max;
        $rules['update']['hours'] .= '|max:' . $max;

        $this->validator->setRules($rules);
    }

    public function checkHours($hours, $id)
    {
        if (app('auth')->getUser()->name === 'ANA CAROLINA CALVETI' || app('auth')->getUser()->name === "VERONICA SALVATI") {
            return ['check' => true, 'hours' => $hours];
        }
        $allocation = $this->repository->find($id);
        $check = $allocation->hours  >= $hours;

        return ['check' => $check, 'hours' => $allocation->hours];
    }

    private function changevalidation()
    {
        $rules       = $this->validator->getRules();
        $rules['create']['task_id'] = 'integer|exists:tasks,id';
        $rules['update']['task_id'] = 'integer|exists:tasks,id';

        $this->validator->setRules($rules);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function getActualHours($data)
    {
        $start       = Carbon::createFromFormat('d/m/Y', $data['start']);
        $finish      = Carbon::createFromFormat('d/m/Y', $data['finish']);
        $actualHours = $this->repository->findWhere([
            ['start', '>=', $start->format('Y-m-d')],
            ['finish', '<=', $finish->format('Y-m-d')],
            'user_id' => $data['user_id']
        ])
            ->sum('hours');

        return $actualHours;
    }

    /**
     * @param array $data
     *
     * @return int
     */
    private function countWorkDays(array $data): int
    {
        $quantity   = 0;
        $diffInDays = $this->getDateRange($data['start'], $data['finish']);
        $exceptionWorkDays = $data['jobWeekEnd'];
        foreach ($diffInDays as $day) {
            if ($this->isWorkingDay($day, $exceptionWorkDays)) {
                $quantity++;
            }
        }
        return $quantity;
    }

    public function addHoursLimitValidate($id)
    {
        $rules = $this->validator->getRules();
        $max = $this->repository->find($id)->hours;
        $rules['create']['hours'] .= '|max:' . $max;
        $rules['update']['hours'] .= '|max:' . $max;

        $this->validator->setRules($rules);
    }

    /**
     * @param array $data
     */
    private function fireEvent(array $data)
    {
        $allocation = new Allocation($data);
        $this->event->fire(new SavedAllocation($allocation));
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function delete($id)
    {
        $allocation = $this->repository->find($id);
        $deleted    = $this->repository->makeModel()
            ->find($id)
            ->forceDelete();
        $this->event->fire(new DeletedAllocation($allocation));
        return $deleted;
    }

    /**
     * @return string
     */
    public function repositoryClass(): string
    {
        return AllocationRepositoryEloquent::class;
    }

    public function createTask(array $data, int $id)
    {

        $allocation = $this->repository->find($id);

        $task = app(TaskRepository::class)->find($data['task_id']);


        if ($allocation) {
            \DB::beginTransaction();
            $allocationTask = AllocationTask::create(array_merge(['allocation_id' => $allocation->id], $data));
            $childAllocations = $this->repository->findWhere(['parent_id' => $id]);
            $allocationTasks = [];

           
            foreach ($childAllocations as $child) {
                $allocationTask = AllocationTask::create(array_merge(['allocation_id' => $child->id], $data));
                $allocationTasks[] = $allocationTask;
            }

            if(strtoupper($task->name) == 'CONTROLE DE PROJETOS'){
                $allocation->automatic = true;
                $allocation->save();

                foreach ($childAllocations as $child){
                   $child->automatic = true;
                   $child->save();
                }
            }

            \DB::commit();
        }
        return $allocationTasks;
    }

    public function updateTask(array $data, int $id,int $allocationTaskId){
        $allocationFather = $this->repository->find($id);
        $allocationTasks =[];
        if($allocationFather){
            \DB::beginTransaction();
            $childAllocations = $this->repository->findWhere(['parent_id' => $id]);
            $task = $allocationFather->allocationTasks->where('id', $allocationTaskId)->first();
            $task->update($data);
            $this->deleteTask($id,$task->id);

            foreach ($childAllocations as $child) {

                foreach($allocationFather->allocationTasks as $taskFather){
                    $allocationTask = AllocationTask::create(array_merge(['allocation_id' => $child->id],[
                        'task_id' => $taskFather->id,
                        'hours' => $taskFather->hours
                    ]));
                    $allocationTasks[] = $allocationTask;
                }
              
            }
            
            \DB::commit();
        }
        return $allocationTasks;
    }

    public function deleteTask(int $id,$allocationTaskId)
    {
        $allocationFather = $this->repository->find($id);
        
        if ($allocationFather) {
            \DB::beginTransaction();
            foreach ($allocationFather->allocationTasks as $task) {
                if($task->id == $allocationTaskId){
                    $task->delete();
                }
            }
          
            $childAllocations = $this->repository->findWhere(['parent_id' => $id]);
            foreach ($childAllocations as $child) {
                foreach ($child->allocationTasks as $task) {
                    $task->delete();
                }
            }

            foreach($childAllocations as $child){
                foreach($allocationFather->allocationTasks as $taskFather){
                    AllocationTask::create(array_merge(['allocation_id' => $child->id],[
                        'task_id' => $taskFather->task_id,
                        'hours' => $taskFather->hours
                    ]));
                }
            }

            \DB::commit();
        }
    }


    public function deleteAllTask(int $id,$deleteTasksFather=false)
    {
        $allocationFather = $this->repository->find($id);
        
        if ($allocationFather) {
            \DB::beginTransaction();
            if($deleteTasksFather){
                foreach ($allocationFather->allocationTasks as $task) {
                    $task->delete();
                }
            }
          
            $childAllocations = $this->repository->findWhere(['parent_id' => $id]);
            foreach ($childAllocations as $child) {
                foreach ($child->allocationTasks as $task) {
                    $task->delete();
                }
            }

            \DB::commit();
        }
    }

    public function generate(array $data)
    {
        $data['jobWeekEnd'] = isset($data['jobWeekEnd']);
        $this->addValidationToDates($data);
        $this->addValidationToHours($data);

        $data['group_company_id'] = \Auth::user()->groupCompany->id;

        // $this->validator->with($data)
        //     ->passesOrFail(ValidatorInterface::RULE_CREATE);


        $allocationFather  = $this->repository->create($data);
        $allocations       = collect();
        $data['parent_id'] = $allocationFather->id;
        $total = $data['hours'];
        $remain = 0;
        $calculed = 0;
        \DB::transaction(function () use ($data, $allocations, $total, $remain, $calculed) {
            $diffInDays    = $this->getDateRange($data['start'], $data['finish']);
            if ($this->countWorkDays($data) > 0) {
                $remain =  ($data['hours'] % $this->countWorkDays($data));
                $calculed = (int)($data['hours'] / $this->countWorkDays($data));
                $total = $data['hours'] - $remain;
                $data['hours'] =  $calculed;
            }
            $exceptionWorkDays = $data['jobWeekEnd'];

            $workDays = $this->countWorkDays($data);
            foreach ($diffInDays as $day) {
                $data['start']  = $day->format('d/m/Y');
                $data['finish'] = $day->format('d/m/Y');

                if ($this->isWorkingDay($day, $exceptionWorkDays)) {
                    $workDays--;
                    if ($workDays == 0) {
                        $data['hours'] += $remain;
                    } else {
                        if ($total > 0) {
                            $total -= $calculed;
                        } else {
                            $data['hours'] = 0;
                        }
                    }

                    $allocation = $this->repository->create($data);
                    $allocations->push($allocation);
                }
            }
        });
        $this->fireEvent($data);

        return $allocations;
    }

    public function updateGenerate(array $data, $id)
    {
        $data['jobWeekEnd'] = isset($data['jobWeekEnd']);
        $this->validator->setId($id);
        $allocations = collect();
        if (app('auth')->getUser()->name === 'ANA CAROLINA CALVETI' || app('auth')->getUser()->name === "VERONICA SALVATI") {
            $this->changevalidation();
        } else {
            $this->addHoursLimitValidate($id);
        }
        // $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $beforeFaterAllocation = $this->repository->find($id);
        $faterAllocation = $this->repository->update($data, $id);
        $data['parent_id'] = $faterAllocation->id;
        $remain = 0;
        $calculed = 0;
        $total = $data['hours'];
        if ($faterAllocation) {

            $childAllocations = $this->repository->findWhere(['parent_id' => $id]);
            \DB::transaction(function () use ($childAllocations, $data, $allocations, $total, $calculed, $remain) {
                foreach ($childAllocations as $allocation) {
                    $allocation->forceDelete();
                }
                $diffInDays    = $this->getDateRange($data['start'], $data['finish']);

                if ($this->countWorkDays($data) > 0) {
                    $remain =  ($data['hours'] % $this->countWorkDays($data));
                    $calculed = (int)($data['hours'] / $this->countWorkDays($data));
                    $data['hours'] =  $calculed;
                }

                $exceptionWorkDays = $data['jobWeekEnd'];
                $workDays = $this->countWorkDays($data);
                foreach ($diffInDays as $day) {
                    $data['start']  = $day->format('d/m/Y');
                    $data['finish'] = $day->format('d/m/Y');

                    if ($this->isWorkingDay($day, $exceptionWorkDays)) {
                        $workDays--;
                        if ($workDays == 0) {
                            $data['hours'] += $remain;
                        } else {
                            if ($total > 0) {
                                $total -= $calculed;
                            } else {
                                $data['hours'] = 0;
                            }
                        }

                        $allocation = $this->repository->create($data);
                        $allocations->push($allocation);
                    }
                }
            });
        }

        $this->fireEvent($data);
        return $allocations;
    }
}
