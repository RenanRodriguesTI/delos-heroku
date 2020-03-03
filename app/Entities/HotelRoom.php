<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class HotelRoom extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['name'];

    public $timestamps = false;
}