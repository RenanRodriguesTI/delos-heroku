<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class GroupValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'name'	=>'	required|min:2|max:255|unique:groups,group_company_id',
		'cod' => 'digits:2|unique:groups,group_company_id',
        'group_company_id' => 'integer:exists:group_companies'
	],
        ValidatorInterface::RULE_UPDATE => [
		'name'	=>'	required|min:2|max:255|unique:groups,group_company_id',
		'cod' => 'required|digits:2|unique:groups,group_company_id',
        'group_company_id' => 'integer:exists:group_companies'
	],
   ];
}