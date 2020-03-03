<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class FinancialRating extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
		'cod',
		'description',
        'group_company_id'
	];

    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }
}
