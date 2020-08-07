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
    ];

    public function allocation(){
        return $this->belongsTo(Allocation::class);
    }

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
