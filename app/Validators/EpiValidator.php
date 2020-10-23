<?php

namespace Delos\Dgp\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EpiValidator.
 *
 * @package namespace Delos\Dgp\Validators;
 */
class EpiValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'=>'required|unique:epis,name',
            // 'ca'=>'numeric',
            // 'shelf_life' => 'required|date_format:d/m/Y',
            // 'user_id' => 'exists:users,id',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'=>'required|unique:epis,name',
            // 'ca'=>'numeric',
            // 'shelf_life' => 'required|date_format:d/m/Y',
            // 'user_id' => 'exists:users,id',
        ],
    ];
}
