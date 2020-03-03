<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProjectTypeValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|between:2,255|unique:project_types,group_company_id',
            'group_company_id' => 'integer:exists:group_companies'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string|between:2,255|unique:project_types,group_company_id',
            'group_company_id' => 'integer|exists:group_companies'
        ],
   ];
}
