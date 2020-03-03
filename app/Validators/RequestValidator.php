<?php

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class RequestValidator extends LaravelValidator
{

    protected $rules = [

        ValidatorInterface::RULE_CREATE => [

//            Rules of Request
            'request.start'           => 'required|date_format:d/m/Y',
            'request.finish'          => 'required|date_format:d/m/Y',
            'request.project_id'      => 'required|integer|exists:projects,id',
            'request.collaborators.*' => 'required|integer|exists:users,id',
            'request.notes'           => 'string|max:255',

//            Rules of Ticket
            'ticket.going_arrival_date'    => 'required_if:has_ticket,true|date_format:d/m/Y|after:yesterday',
            'ticket.going_arrival_time'    => 'required_if:has_ticket,true',
            'ticket.going_from_airport_id' => 'required_if:has_ticket,true|integer|exists:airports,id',
            'ticket.going_to_airport_id'   => 'required_if:has_ticket,true|integer|exists:airports,id',
            'ticket.back_arrival_date'     => 'required_if:has_ticket,true|date_format:d/m/Y',
            'ticket.back_arrival_time'     => 'required_if:has_ticket,true',
            'ticket.back_from_airport_id'  => 'required_if:has_ticket,true|integer|exists:airports,id',
            'ticket.back_to_airport_id'    => 'required_if:has_ticket,true|integer|exists:airports,id',

//            Rules of lodging
            'lodging.check_in'      => 'required_if:has_lodging,true|date_format:d/m/Y|after:yesterday',
            'lodging.checkout'      => 'required_if:has_lodging,true|date_format:d/m/Y',
            'lodging.city_id'       => 'required_if:has_lodging,true|integer|exists:cities,id',
            'lodging.hotel_room_id' => 'required_if:has_lodging,true|integer|exists:hotel_rooms,id',
            'lodging.suggestion'    => 'string|max:255',

//            Rules of car
            'car.car_type_id'      => 'required_if:has_car,true|integer|exists:car_types,id',
            'car.withdrawal_date'  => 'required_if:has_car,true|required_if:car_type_id,1,car_type_id,3,has_car,on|date_format:d/m/Y|after:yesterday',
            'car.return_date'      => 'required_if:has_car,true|required_if:car_type_id,1,car_type_id,3,has_car,on|date_format:d/m/Y',
            'car.return_hour'      => 'required_if:has_car,true|required_if:car_type_id,1,car_type_id,3,has_car,on',
            'car.first_driver_id'  => 'required_if:has_car,true|required_if:car_type_id,1,car_type_id,3,has_car,on|integer|exists:users,id',
            'car.withdrawal_hour'  => 'required_if:has_car,true|required_if:car_type_id,1,car_type_id,3,has_car,on',
            'car.withdrawal_place' => 'required_if:car_type_id,1|string|between:2,255',
            'car.return_place'     => 'required_if:car_type_id,1|string|between:2,255',

//            Rules of extra expenses
            'extra.food.start'        => 'date_format:d/m/Y|after:yesterday',
            'extra.food.finish'       => 'date_format:d/m/Y',
            'extra.taxi.value'        => 'regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'extra.toll.value'        => 'regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'extra.fuel.value'        => 'regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'extra.other.value'       => 'required_with:extra.other.description|regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'extra.other.description' => 'required_with:extra.other.value|string|max:255',
        ]
    ];

}
