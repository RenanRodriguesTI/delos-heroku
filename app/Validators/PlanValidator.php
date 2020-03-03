<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 22/08/17
 * Time: 15:11
 */

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class PlanValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|min:0|max:100|string',
            'billing_type' => 'required|in:auto,manual',
            'periodicity' => 'required|in:WEEKLY,MONTHLY,BIMONTHLY,TRIMONTHLY,SEMIANNUALLY,YEARLY',
            'value' => 'required|regex:/^\d+(,\d{2})?$/',
            'trial_period' => 'required|min:0|integer',
            'max_users' => 'integer',
            'description' => 'required|string|min:2|max:255'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:0|max:100|string',
            'billing_type' => 'required|in:auto,manual',
            'periodicity' => 'required|in:WEEKLY,MONTHLY,BIMONTHLY,TRIMONTHLY,SEMIANNUALLY,YEARLY',
            'value' => 'required|regex:/^\d+(,\d{2})?$/',
            'trial_period' => 'required|min:0|integer',
            'max_users' => 'integer',
            'description' => 'required|string|min:2|max:255'
        ]
    ];
}