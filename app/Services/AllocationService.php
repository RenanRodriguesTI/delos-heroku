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
            $data['jobWeekEnd'] =isset($data['jobWeekEnd']);
           if(app('auth')->getUser()->name === 'ANA CAROLINA CALVETI' || app('auth')->getUser()->name === "VERONICA SALVATI"){
            //    if(!$data['task_id']){
            //     unset($data['task_id']);
            //    }
                
                $this->changevalidation();
           }

           if(isset($data['task_id']) && !$data['task_id']){
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

            \DB::transaction(function () use ($data, $allocations) {
                $diffInDays    = $this->getDateRange($data['start'], $data['finish']);
                if($this->countWorkDays($data) >0){
                    $data['hours'] = $data['hours'] / $this->countWorkDays($data);
                }
                $exceptionWorkDays = $data['jobWeekEnd'];


                foreach ( $diffInDays as $day ) {
                    $data['start']  = $day->format('d/m/Y');
                    $data['finish'] = $day->format('d/m/Y');

                    if ( $this->isWorkingDay($day,$exceptionWorkDays) ) {
                        $allocation = $this->repository->create($data);
                        $allocations->push($allocation);
                    }
                }
            });
            $this->fireEvent($data);

            return $allocations;
        }

        public function update(array $data, $id){
            $data['jobWeekEnd'] =isset($data['jobWeekEnd']);
            $this->validator->setId($id);       
            $allocations = collect();
            
            if(isset($data['task_id'])){
                unset($data['task_id']);
                $this->changevalidation();
            }
            if(app('auth')->getUser()->name === 'ANA CAROLINA CALVETI' || app('auth')->getUser()->name === "VERONICA SALVATI"){
                // if(!$data['task_id']){
                //  unset($data['task_id']);
                // }
                 
                 $this->changevalidation();
               
            } else{
                $this->addHoursLimitValidate($id);
            }
           $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
           $beforeFaterAllocation = $this->repository->find($id);
           $faterAllocation = $this->repository->update($data, $id);
           $data['parent_id'] = $faterAllocation->id;
           if($faterAllocation){
                $childAllocations = $this->repository->findWhere(['parent_id' => $id]);
                \DB::transaction(function() use($childAllocations, $data,$allocations){
                    foreach( $childAllocations as $allocation){
                        $allocation->forceDelete();
                    }
                    $diffInDays    = $this->getDateRange($data['start'], $data['finish']);

                    if($this->countWorkDays($data) >0){
                        $data['hours'] = $data['hours'] / $this->countWorkDays($data);
                    }
                    
                    
                    $exceptionWorkDays = $data['jobWeekEnd'];

                    foreach ( $diffInDays as $day ){
                        $data['start']  = $day->format('d/m/Y');
                        $data['finish'] = $day->format('d/m/Y');
    
                        if ( $this->isWorkingDay($day,$exceptionWorkDays) ) {
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

        public function checkHours($hours,$id){
            if(app('auth')->getUser()->name === 'ANA CAROLINA CALVETI' || app('auth')->getUser()->name === "VERONICA SALVATI"){
                return ['check'=>true,'hours' => $hours];
            }
            $allocation = $this->repository->find($id);
            $check= $allocation->hours  >= $hours;

            return ['check'=>$check,'hours' =>$allocation->hours];
        }
    
        private function changevalidation(){
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
            foreach ( $diffInDays as $day ) {
                if ( $this->isWorkingDay($day,$exceptionWorkDays) ) {
                    $quantity++;
                }
            }
            return $quantity;
        }

        public function addHoursLimitValidate($id){
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

        public function createTask(array $data,int $id){
            $allocation = $this->repository->find($id);
            $allocationTask = AllocationTask::create(array_merge(['allocation_id' =>$allocation->id],$data));
            return $allocationTask;
        }
    }