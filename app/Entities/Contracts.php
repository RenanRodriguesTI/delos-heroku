<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contracts extends Model
{
    protected $fillable = [
        'start',
        'end',
        'value',
        'user_id'
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'value' => 'float',
    ];

    public function setAttributeStart($value){
        $attributes['start'] = Carbon::createFromFormat('d/m/Y',$value);
    }

    public function setAttributeEnd($value){
        $attributes['end'] = Carbon::createFromFormat('d/m/Y',$value);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
