<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 19/07/17
 * Time: 17:52
 */

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class CompanyValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|min:1|max:255|string',
            'group_company_id' => 'integer:exists:group_companies'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:1|max:255|string',
            'group_company_id' => 'integer:exists:group_companies'
        ]
    ];
}