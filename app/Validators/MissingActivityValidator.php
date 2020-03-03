<?php

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class MissingActivityValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required|integer|exists:users,id',
            'date' => 'required|date_format:Y-m-d',
            'hours' => 'required|integer|between:1,8'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'user_id' => 'required|integer|exists:users,id',
            'date' => 'required|date_format:Y-m-d',
            'hours' => 'required|integer|between:1,8'
        ],
   ];
}
