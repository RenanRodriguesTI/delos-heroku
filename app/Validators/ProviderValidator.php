<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
/**
 * Class ProviderValidator.
 *
 * @package namespace Delos\Dgp\Validators;
 */
class ProviderValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'email' =>['required','email:rfc'],
            'social_reason' =>'required',
            'cnpj' => ['required'],
            'telephone' => ['required'],
            'name' => ['required'],
            'accountnumber' => ['required']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'email' =>['required','email:rfc'],
            'social_reason' =>'required',
            'cnpj' => ['required'],
            'telephone' => ['required'],
            'name' => ['required'],
            'accountnumber' => ['required']
        ],
    ];
}
