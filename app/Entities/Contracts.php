<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contracts extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'start',
        'end',
        'value',
        'user_id',
        'note'
    ];

    protected $casts = [
      
        'value' => 'float',
    ];

    protected $dates =[
        'start',
        'end',
        'created_at',
        'updated_at',
        'delete_at'
    ];

    public function setStartAttribute($value){
        $this->attributes['start'] = Carbon::createFromFormat('d/m/Y',$value);
    }

    public function setEndAttribute($value){
        $this->attributes['end'] = Carbon::createFromFormat('d/m/Y',$value);
    }

    public function projects(){
        return $this->belongsToMany(Project::class,'contract_project');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
