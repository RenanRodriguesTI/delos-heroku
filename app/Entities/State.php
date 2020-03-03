<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class State extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['name'];

    public function airports()
    {
        return $this->hasMany(Airport::class);
    }

    public function lodgings()
    {
        return $this->hasMany(Lodging::class);
    }
}
