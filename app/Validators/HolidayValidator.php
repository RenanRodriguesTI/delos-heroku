<?php

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class HolidayValidator extends LaravelValidator
{
	protected $rules = [
		ValidatorInterface::RULE_CREATE => [
			'description' => 'required|string|max:255|unique:holidays',
			'date' => 'required|date_format:d/m/Y'

		],

		ValidatorInterface::RULE_UPDATE => [
			'description' => 'required|string|max:255|unique:holidays',
			'date' => 'required|date_format:d/m/Y'
		],
	];
}