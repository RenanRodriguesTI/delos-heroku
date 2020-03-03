<?php

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class CityValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|between:2,255|unique:cities',
            'state_id' => 'required|integer|exists:states,id'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string|between:2,255|unique:cities',
            'state_id' => 'required|integer|exists:states,id'
        ],
    ];
}
