<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class CarTypeValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'name' => 'required|string|min:2|max:255|unique:car_types',
	],
        ValidatorInterface::RULE_UPDATE => [
		'name' => 'required|string|min:2|max:255|unique:car_types',
	],
   ];

}