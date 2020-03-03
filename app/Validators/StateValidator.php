<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class StateValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|size:2|unique:states'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string|size:2|unique:states'
        ],
   ];
}
