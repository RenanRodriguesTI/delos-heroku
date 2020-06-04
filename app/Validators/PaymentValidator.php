<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class PaymentValidator.
 *
 * @package namespace Delos\Dgp\Validators;
 */
class PaymentValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'=>'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'=>'required'
        ],
    ];
}
