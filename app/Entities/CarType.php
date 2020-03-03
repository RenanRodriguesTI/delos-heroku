<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class CarType extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
		'name',
	];

}
