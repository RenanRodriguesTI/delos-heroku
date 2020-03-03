<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemporaryImport extends Model
{
    use SoftDeletes;
    
    protected $fillable =[
        'id',
        'project_code',
        'os',
        'status',
        'description',
        'date_migration'
    ];

    protected $casts =[
        'date_migration' => 'datetime'
    ];
}
