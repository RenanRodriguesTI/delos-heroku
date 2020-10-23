<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Resource extends Model
{
    protected $fillable =[
        'start',
        'finish',
        'status',
        'user_id',
        'allocation_task_id',
        'hours',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function allocationTask(){
        return $this->belongsTo(AllocationTask::class);
    }

    public function setStartAttribute($value){
         if($value){
            $this->attributes['start'] = Carbon::createFromFormat('d/m/Y',$value);
         }
    }

    public function setFinishAttribute($value){
        if($value){
            $this->attributes['finish'] = Carbon::createFromFormat('d/m/Y',$value);
        }
    }

}
