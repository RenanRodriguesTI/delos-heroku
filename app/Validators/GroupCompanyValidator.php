<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/07/17
 * Time: 16:04
 */

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class GroupCompanyValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|min:0|max:255|unique:group_companies',
            'plan_id' => 'required|exists:plans,id'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:0|max:255|unique:group_companies',
            'plan_id' => 'required|exists:plans,id'
        ]
    ];
}