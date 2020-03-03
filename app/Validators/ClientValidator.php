<?php

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [        
		'name'	=>'	required|max:255',
		'cod' => 'digits:3|',
		'group_id' => [
		    'required'
            ,'integer'
        ],
        'group_company_id' => 'integer|exists:group_companies,id'
	],
        ValidatorInterface::RULE_UPDATE => [
		'name'	=>'required|max:255',
		'cod' => 'required|digits:3',
		'group_id' => 'required|integer|exists:groups,id',
        'group_company_id' => 'integer|exists:group_companies,id'
	],
   ];
}