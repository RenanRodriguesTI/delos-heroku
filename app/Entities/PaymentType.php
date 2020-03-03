<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class PaymentType extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['name'];

    public function expenseTypes()
    {
        return $this->belongsToMany(\Delos\Dgp\Entities\ExpenseType::class);
    }
}
