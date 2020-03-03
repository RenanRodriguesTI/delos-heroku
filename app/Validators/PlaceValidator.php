<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class PlaceValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'name'	=>'	required|min:2|max:255|unique:places',
	],
        ValidatorInterface::RULE_UPDATE => [
		'name'	=>'	required|min:2|max:255|unique:places',
	],
   ];

}