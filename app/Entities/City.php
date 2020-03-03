<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class City extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['name', 'state_id'];

    protected $casts = ['state_id' => 'integer'];

    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
