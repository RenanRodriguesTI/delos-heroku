<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CurseValidator.
 *
 * @package namespace Delos\Dgp\Validators;
 */
class CurseValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'=>'required|unique:curses,name',
            'end_date'=>'required|date_format:d/m/Y',
            'renewal_date'=>'date_format:d/m/Y',
            'user_id' => 'required|exists:users,id',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'=>'required',
            'end_date'=>'required|date_format:d/m/Y',
            'renewal_date'=>'date_format:d/m/Y',
            'user_id' => 'required|exists:users,id',
        ],
    ];
}
