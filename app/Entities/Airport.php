<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Airport extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['state_id', 'initials', 'name'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
