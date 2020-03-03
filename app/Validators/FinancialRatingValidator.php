<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class FinancialRatingValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'cod' => 'required|size:2|unique:financial_ratings,group_company_id',
		'description' => 'required|min:2|max:255',
        'group_company_id' => 'integer:exists:group_companies'
	],
        ValidatorInterface::RULE_UPDATE => [
		'cod' => 'required|size:2|unique:financial_ratings,group_company_id',
		'description' =>'required|min:2|max:255',
        'group_company_id' => 'integer:exists:group_companies'
	],
   ];

}