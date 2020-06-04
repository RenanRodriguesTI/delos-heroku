<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class PaymentTypeProviders extends AbstractAudit
{
    use RelationshipsTrait;
    use SoftDeleteWithRestoreTrait;
    
    protected $fillable = [
        'name',
        'ative'
    ];
}
