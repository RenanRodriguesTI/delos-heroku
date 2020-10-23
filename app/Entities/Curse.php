<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Curse.
 *
 * @package namespace Delos\Dgp\Entities;
 */
class Curse extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'end_date',
        'renewal_date',
        'filename',
        'file_s3',
        'user_id',
    ];

    protected $dates =[
        'end_date',
        'renewal_date',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getFileURLAttribute(){
        return env('FILESYSTEM_DISK') == 's3' ? Storage::url('curses/uploads/'.$this->file_s3): asset('curses/uploads'.$this->file_s3);
    }

    public function setEndDateAttribute($value){
        if($value){
            $this->attributes['end_date'] = Carbon::createFromFormat('d/m/Y',$value);
        }
    }

    public function setRenewalDateAttribute($value){
        if($value){
            $this->attributes['renewal_date'] = Carbon::createFromFormat('d/m/Y',$value);
        }
    }

    public function getExpiredAttribute(){
        $now = Carbon::now();

        if($this->attributes['end_date']){
            return $now->greaterThan($this->attributes['end_date']);
        }

        return false;
    }

}
