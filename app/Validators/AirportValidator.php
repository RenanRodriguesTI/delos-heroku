<?php

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class AirportValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'     => 'required|string|between:2,255|unique:airports',
            'initials' => 'required|string|between:2,255|unique:airports',
            'state_id' => 'required|integer|exists:states,id'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'     => 'required|string|between:2,255|unique:airports',
            'initials' => 'required|string|between:2,255|unique:airports',
            'state_id' => 'required|integer|exists:states,id'
        ],
    ];
}
