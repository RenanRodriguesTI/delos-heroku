<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class ExtraExpense extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['request_id', 'description', 'value'];

	protected $casts = ['request_id' => 'integer','value' => 'float'];

	public function request()
	{
		return $this->belongsTo(Request::class);
	}
}
