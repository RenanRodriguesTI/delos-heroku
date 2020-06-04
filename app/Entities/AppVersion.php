<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class AppVersion extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable =[
        'version',
        'important'
    ];

    protected $casts = [
        'important' =>'boolean'
    ];
}
