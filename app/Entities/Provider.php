<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{

    use SoftDeletes;
    
    protected $fillable =[
        'email',
        'note',
        'social_reason',
        'cnpj',
        'telephone',
    ];

    protected $dates =[
        'deleted_at'
    ];


}
