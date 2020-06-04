<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class PaymentType extends AbstractAudit
{
    use RelationshipsTrait;
    use SoftDeleteWithRestoreTrait;

    protected $fillable = [
        'name',
        'ative'
    ];

    public function expenseTypes()
    {
        return $this->belongsToMany(\Delos\Dgp\Entities\ExpenseType::class);
    }
}
