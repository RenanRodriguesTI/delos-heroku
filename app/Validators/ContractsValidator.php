<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ContractsValidator.
 *
 * @package namespace Delos\Dgp\Validators;
 */
class ContractsValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'start' =>'required',
            'end' => 'required',
            'value' => 'required',
            'user_id' =>'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'start' =>'required',
            'end' => 'required',
            'value' => 'required',
            'user_id' => 'required'
        ],
    ];
}
