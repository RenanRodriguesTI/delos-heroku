<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'cod' => 'max:255',
            'description' => 'max:255',
            'project_type_id' => 'required|integer|exists:project_types,id',
            'financial_rating_id' => 'required|integer|exists:financial_ratings,id',
            'clients' => 'required|array',
            'client_id' => 'integer|exists:users,id',
            'owner_id' => 'required|integer|exists:users,id',
            'os' =>'unique:project_proposal_values,os',
            'co_owner_id' => 'integer|exists:users,id|different:owner_id',
            'budget' => 'required|integer',
            'extended_budget' =>'integer',
            'proposal_value' => 'required',
            'proposal_number' => 'max:255',
            'start' => 'required|date_format:d/m/Y',
            'finish' => 'required|date_format:d/m/Y|after_or_equal:start',
            'company_id' => 'required|integer|exists:companies,id',
            'notes' => 'string|max:255',
            'extra_expenses' => 'max:255',
            'seller_id' => 'bail|integer|exists:users,id',
            'commission' => 'bail|string|max:255'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'cod' => 'required|max:255',
            'description' => 'required|max:255',
            'project_type_id' => 'required|integer|exists:project_types,id',
            'financial_rating_id' => 'required|integer|exists:financial_ratings,id',
            'clients' => 'required|array',
            'client_id' => 'integer|exists:users,id',
            'owner_id' => 'required|integer|exists:users,id',
            'os' =>'unique:project_proposal_values,os',
            'co_owner_id' => 'integer|exists:users,id|different:owner_id',
            'budget' => 'required|integer',
            'extended_budget' =>'integer',
            'proposal_value' => 'required|numeric',
            'proposal_number' => 'max:255',
            'start' => 'required|date_format:d/m/Y',
            'finish' => 'required|date_format:d/m/Y|after_or_equal:start',
            'company_id' => 'required|integer|exists:companies,id',
            'notes' => 'string|max:255',
            'extra_expenses' => 'numeric',
            'seller_id' => 'bail|integer|exists:users,id',
            'commission' => 'required_with:seller_id|numeric'
        ],
    ];

}