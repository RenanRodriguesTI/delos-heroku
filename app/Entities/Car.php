<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Car extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
        'request_id',
        'car_type_id',
        'withdrawal_date',
        'return_date',
        'withdrawal_place',
        'return_place',
        'first_driver_id',
        'second_driver_id',
        'client_pay'
    ];

    protected $casts = [
        'withdrawal_date'  => 'datetime',
        'return_date'      => 'datetime',
        'request_id'       => 'integer',
        'car_type_id'      => 'integer',
        'first_driver_id'  => 'integer',
        'second_driver_id' => 'integer',
        'client_pay'       => 'boolean'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function firstDriver()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function secondDriver()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
