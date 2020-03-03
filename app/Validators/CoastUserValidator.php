<?php

    namespace Delos\Dgp\Validators;

    use \Prettus\Validator\Contracts\ValidatorInterface;
    use \Prettus\Validator\LaravelValidator;

    /**
     * Class CoastUserValidator.
     *
     * @package namespace Delos\Dgp\Validators;
     */
    class CoastUserValidator extends LaravelValidator
    {
        /**
         * Validation Rules
         *
         * @var array
         */
        protected $rules = [
            ValidatorInterface::RULE_CREATE => [
                'user_id'     => 'required|integer|exists:users,id',
                'date'       => 'required|date',
            ],
            ValidatorInterface::RULE_UPDATE => [
                'user_id'     => 'integer|exists:users,id',
                'date'       => 'date',
            ],
        ];
    }
