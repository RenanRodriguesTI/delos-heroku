<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ApprovedNotification.
 *
 * @package namespace Delos\Dgp\Entities;
 */
class ApprovedNotification extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'subtitle',
        'value',
        'approved',
        'ready',
        'user_id',
        'leader_id',
        'type_notify_id',
        'reason'
    ];

    protected $casts  =[
        'approved' => 'boolean',
        'ready' => 'boolean',
        'value'=>'float'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function leader(){
        return $this->belongsTo(User::class);
    }

    public function TypeNotify(){
        return $this->belongsTo(TypeNotify::class);
    }

}
