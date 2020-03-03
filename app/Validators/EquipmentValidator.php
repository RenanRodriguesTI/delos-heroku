<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EquipmentValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'description' =>'required|min:2|max:255|unique:equipments',
	],
        ValidatorInterface::RULE_UPDATE => [
		'description' =>'required|min:2|max:255|unique:equipments',
	],
   ];

}