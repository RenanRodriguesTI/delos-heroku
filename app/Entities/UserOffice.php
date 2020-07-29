<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Carbon\Carbon;

class UserOffice extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable =[
        'user_id',
        'office_id',
        'start',
        'finish',
    ];

    protected $dates =[
        'start',
        'finish'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function setStartAttribute($value){
        $this->attributes['start'] = Carbon::createFromFormat('d/m/Y',$value);
    }

    public function setFinishAttribute($value){
        if($value){
            $this->attributes['finish'] = Carbon::createFromFormat('d/m/Y',$value);
        }
    }

    public function getValueAttribute(){

        
       $history = !$this->office->officeHistory->isEmpty() ?  $this->office->officeHistory
        ->where('start','>=',$this->start->format('Y-m-d'))
        ->where('finish','>=',$this->start->format('Y-m-d'))
        ->first() : null;

        if(!$history){
            $history=  !$this->office->officeHistory->isEmpty() ? $this->office->officeHistory->where('start','>=',$this->start->format('Y-m-d'))
                ->where('finish',null)->first(): null;
        }

        return $history ? $history->value :0;
    }

}
