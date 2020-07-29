<?php

    namespace Delos\Dgp\Validators;

    use Prettus\Validator\Contracts\ValidatorInterface;
    use Prettus\Validator\LaravelValidator;

    class UserValidator extends LaravelValidator
    {

        protected $rules = [
            ValidatorInterface::RULE_CREATE => [
                'name'                => 'required|string|min:2|max:255',
                'email'               => 'required|email|max:255|unique:users',
                'admission'           => 'required|date_format:d/m/Y|before:tomorrow',
                'role_id'             => 'required|integer|exists:roles,id',
                'supplier_number'     => 'string',
                'company_id'          => 'required|integer',
                'account_number'      => 'string',
                'is_partner_business' => 'integer',
                'group_company_id'    => 'integer:exists:group_companies',
                'notes'               => 'string|max:255',
                'office_id' =>'required|exists:offices,id',
                'start' => 'required|date_format:d/m/Y'
            ],

            ValidatorInterface::RULE_UPDATE => [
                'name'                => 'required|string|min:2|max:255',
                'email'               => 'required|email|max:255|unique:users',
                'admission'           => 'required|date_format:d/m/Y|before:tomorrow',
                'role_id'             => 'required|integer|exists:roles,id',
                'supplier_number'     => 'string',
                'company_id'          => 'required|integer',
                'account_number'      => 'string',
                'is_partner_business' => 'integer',
                'group_company_id'    => 'integer:exists:group_companies',
                'notes'               => 'string|max:255',
                'office_id' =>'exists:offices,id',
                'start' => 'required|date_format:d/m/Y'
            ],
        ];

    }