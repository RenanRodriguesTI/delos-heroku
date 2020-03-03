<?php

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ExpenseTypeValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'cod' =>'required|string',
            'description' =>'required|string',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'cod' =>'string',
            'description' =>'string',
        ],
    ];
}