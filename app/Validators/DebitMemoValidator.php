<?php
/**
 * Created by PhpStorm.
 * User: delos
 * Date: 10/02/2017
 * Time: 18:22
 */

namespace Delos\Dgp\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DebitMemoValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'finish_at' => 'date_format:Y-m-d h:i:s',
            'number' => 'required|max:4'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'finish_at' => 'date_format:Y-m-d h:i:s',
            'number' => 'required|max:4'
        ],
    ];
}