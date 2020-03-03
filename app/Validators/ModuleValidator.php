<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 24/08/17
 * Time: 10:35
 */

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ModuleValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string|between:2,255|unique:modules',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string|between:2,255|unique:modules',
        ],
    ];
}