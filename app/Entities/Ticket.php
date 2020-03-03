<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Ticket extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['arrival', 'preview', 'request_id', 'from_airport_id', 'to_airport_id', 'client_pay'];

	protected $casts = [
		'arrival' => 'datetime',
		'preview' => 'boolean',
		'request_id' => 'integer',
		'from_airport_id' => 'integer',
		'to_airport_id' => 'integer',
        'client_pay' => 'boolean'
	];

	public $timestamps = false;

	public function request()
	{
		return $this->belongsTo(Request::class);
	}

	public function fromAirport()
	{
		return $this->belongsTo(Airport::class);
	}

	public function toAirport()
	{
		return $this->belongsTo(Airport::class);
	}
}
