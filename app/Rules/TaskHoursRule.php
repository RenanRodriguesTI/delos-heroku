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
        if($this->hasupdate){
            $total = AllocationTask::where('allocation_id',$this->id)->whereNotIn('id',[$this->allocationTaskId])->sum('hours'); 
        }else
        $total = AllocationTask::where('allocation_id',$this->id)->sum('hours');
        $total += $value;
        return ($total <= $allocation->hours);
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
