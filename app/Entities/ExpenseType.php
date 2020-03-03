<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class ExpenseType extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['cod', 'description'];

    public function paymentTypes()
    {
        return $this->belongsToMany(\Delos\Dgp\Entities\PaymentType::class);
    }
}
