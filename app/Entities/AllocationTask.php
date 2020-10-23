<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AllocationTask extends Model
{
    protected $fillable =[
        'id',
        'task_id',
        'allocation_id',
        'hours',
        'start',
        'finish'
    ];

    protected $dates = [
        'start',
        'finish',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function allocation(){
        return $this->belongsTo(Allocation::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    /**
     * Set Finish field value to Carbon
     *
     * @param $value
     */
    public function setFinishAttribute($value)
    {
        $this->attributes['finish'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getStartAttribute(){

        if($this->attributes['start'] instanceof Carbon){
            return $this->attributes['start']->format('d/m/Y');
        }
        return $this->attributes['start'] ? Carbon::createFromFormat('Y-m-d',$this->attributes['start'])->format('d/m/Y') : $this->allocation->start->format('d/m/Y');
    }

    public function getFinishAttribute (){
        if($this->attributes['finish'] instanceof Carbon){
            return $this->attributes['finish']->format('d/m/Y');
        }
        return $this->attributes['finish'] ? Carbon::createFromFormat('Y-m-d',$this->attributes['finish'])->format('d/m/Y') : $this->allocation->finish->format('d/m/Y');
    }


}
