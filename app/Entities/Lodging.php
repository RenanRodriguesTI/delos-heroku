<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Lodging extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
		'request_id',
		'check_in',
		'checkout',
		'city_id',
		'second_city_id',
		'suggestion',
		'hotel_room_id',
        'client_pay',
        'state_id'
	];

	protected $casts = [
		'check_in' => 'datetime',
		'checkout' => 'datetime',
		'request_id' => 'integer',
		'city_id' => 'integer',
		'second_city_id' => 'integer',
		'hotel_room_id' => 'integer',
        'client_pay' => 'boolean',
        'state_id' => 'integer'
    ];

	public function request()
	{
		return $this->belongsTo(Request::class);
	}

	public function city()
	{
		return $this->belongsTo(City::class);
	}

	public function secondCity()
	{
		return $this->belongsTo(City::class);
	}

	public function hotelRoom()
	{
		return $this->belongsTo(HotelRoom::class);
	}

	public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function setCheckInAttribute($value)
    {
        $value = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['check_in'] = $value->format('Y-m-d');
    }

    public function setCheckoutAttribute($value)
    {
        $value = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['checkout'] = $value->format('Y-m-d');
    }
}
