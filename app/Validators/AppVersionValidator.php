<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class AppVersionValidator.
 *
 * @package namespace Delos\Dgp\Validators;
 */
class AppVersionValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'version' =>'required',
            'important' =>''
        ],
        ValidatorInterface::RULE_UPDATE => [
            'version' =>'required',
            'important' =>''
        ],
    ];
}
