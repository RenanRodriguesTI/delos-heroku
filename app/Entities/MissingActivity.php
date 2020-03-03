<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class MissingActivity extends AbstractAudit
{
    use SoftDeleteWithRestoreTrait, RelationshipsTrait;

    protected $fillable = ['user_id', 'hours', 'date'];

    protected $casts =[
        'user_id' => 'integer',
        'hours' => 'integer'
    ];

    protected $dates = [
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}