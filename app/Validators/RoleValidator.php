<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class RoleValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'name'	=>'	required|min:2|max:255|unique:roles'
	],
        ValidatorInterface::RULE_UPDATE => [
		'name'	=>'	required|min:2|max:255|unique:roles'
	],
   ];
}