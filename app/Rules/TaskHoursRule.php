<?php

namespace Delos\Dgp\Rules;

use Illuminate\Contracts\Validation\Rule;
use Delos\Dgp\Entities\Allocation;
use Delos\Dgp\Entities\AllocationTask;

class TaskHoursRule implements Rule
{

    private $id;
    private $hasupdate;
    private $allocationTaskId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id=0,$allocationTaskId=0,$hasupdate=false)
    {
        $this->id = $id;
        $this->allocationTaskId =$allocationTaskId;
        $this->hasupdate = $hasupdate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $allocation = Allocation::find($this->id);
        $project = $allocation->project;
        if($this->hasupdate){
            $task = AllocationTask::where('id',$this->allocationTaskId)->first();
            return $value <= ($project->remaining_budget + $task->hours);
        } else{
           return $value <= $project->remaining_budget;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute é maior que a quantidade disponível';
    }
}
