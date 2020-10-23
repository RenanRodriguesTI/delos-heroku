<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * Class Epi.
 *
 * @package namespace Delos\Dgp\Entities;
 */
class Epi extends Model
{
    use RelationshipsTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
    ];

    
    public function epiUser(){
        return $this->hasMany(EpiUser::class);
    }

    public function getByUser($id){
        return $this->epiUser->where('user_id',$id)->get()->first();
    }

}
