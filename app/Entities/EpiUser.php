<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EpiUser extends Model
{
    protected $fillable =[
        'id',
        'ca',
        'shelf_life',
        'filename',
        'file_s3',
        'user_id',
        'epi_id'
    ];

    protected $dates =[
        'shelf_life'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function  epi(){
        return $this->belongsTo(Epi::class);
    }

    public function setShelfLifeAttribute($value){
        if($value){
            $this->attributes['shelf_life'] = Carbon::createFromFormat('d/m/Y',$value);
        } else{
            $this->attributes['shelf_life']= null;
        }
    }

    public function getFileURLAttribute(){
        return env('FILESYSTEM_DISK') == 's3' ? Storage::url('epis/uploads/'.$this->file_s3): asset('epis/uploads'.$this->file_s3);
    }

    public function getExpiredAttribute(){
        $now = Carbon::createFromFormat('d/m/Y',Carbon::now()->format('d/m/Y'));
        if( $this->attributes['shelf_life']){

           $shelf_life = Carbon::createFromFormat('Y-m-d',$this->attributes['shelf_life']);
            $shelf_life->hour(23);
            $shelf_life->minute(59);
            $shelf_life->second(59);
            return $now->greaterThan($shelf_life);
        }
        return false;
    }
}
