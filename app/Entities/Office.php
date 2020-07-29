<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use RelationshipsTrait;
    use SoftDeletes;

    protected $fillable=[
        'name',
        'start',
        'finish',
        'value'
    ];

    protected $dates =[
        'start',
        'finish'
    ];

    public function setStartAttribute($value){
        $this->attributes['start'] = Carbon::createFromFormat('d/m/Y',$value);
    }

    public function setFinishAttribute($value){
        if($value){
            $this->attributes['finish'] = Carbon::createFromFormat('d/m/Y',$value);
        }
    }

    public function officeHistory(){
        return $this->hasMany(OfficeHistory::class);
    }


    public function getStartHistoryAttribute(){
        $now = Carbon::now();
        if($this->id){
            $start = OfficeHistory::where('office_id',$this->id)
            ->whereNull('finish')->first();

            if($start){
                return $start->start;
            } else{
                $start = OfficeHistory::where('office_id',$this->id)
                ->whereRaw("str_to_date('start','%Y-%m') = str_to_date({$now->format('Y-m')},'%Y-%m')")
                ->orderBy('start','desc')
                ->get()
                ->first();

                if($start){
                    return $start->start;
                }

                $start = OfficeHistory::where('office_id',$this->id)
                ->first();

                return  $start ? $start->start :null;
            }
        }

        return null;
    }

    public function getValueHistoryAttribute(){
        $now = Carbon::now();
        if($this->id){
            $start = OfficeHistory::where('office_id',$this->id)
            ->whereNull('finish')->first();

            if($start){
                return $start->value;
            } else{
                $start = OfficeHistory::where('office_id',$this->id)
                ->whereRaw("str_to_date('start','%Y-%m') = str_to_date({$now->format('Y-m')},'%Y-%m')")
                ->orderBy('start','desc')
                ->get()
                ->first();

                if($start){
                    return $start->value;
                }

                $start = OfficeHistory::where('office_id',$this->id)
                ->first();

                return  $start ? $start->value :null;
            }
        }

        return null;
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
