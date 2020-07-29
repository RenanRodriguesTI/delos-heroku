<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OfficeHistory extends Model
{
    protected $fillable =[
        'office_id',
        'start',
        'finish',
        'value'
    ];

    protected $casts =[
        'value' =>'float'
    ];

    protected $dates =[
        'start',
        'finish'
    ];

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

    public function setValueAttribute($value)
    {
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
        $float = $numberFormatter->parse($value);
        $this->attributes['value'] = $float;
    }

    public function getValueAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }
}
