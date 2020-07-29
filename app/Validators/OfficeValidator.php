<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class OfficeValidator.
 *
 * @package namespace Delos\Dgp\Validators;
 */
class OfficeValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'value' =>'required',
            'name' => 'required|unique:offices,name',
            'start' => 'required|date_format:d/m/Y',
            'finish' =>'date_format:d/m/Y'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'value' => '',
            'name' => 'required',
            'start'=>'',
            'finish'=>''
        ],
    ];
}
