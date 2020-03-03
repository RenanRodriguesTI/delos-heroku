<?php

namespace Delos\Dgp\Validators;

use Carbon\Carbon;
use Illuminate\Validation\Factory;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ExpenseValidator extends LaravelValidator {

    private $today;

    public function __construct(Factory $validator)
    {
        parent::__construct($validator);
        $this->today = (new Carbon('today'))->format('d/m/Y');

        $this->rules['create']['issue_date'] .= $this->today;
        $this->rules['update']['issue_date'] .= $this->today;
    }

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required|integer|exists:users,id',
            'request_id' => 'integer|nullable',
            'project_id' => 'integer|nullable',
            'invoice' => 'required|min:1|max:6',
            'invoice_file' => 'required|mimes:jpeg,jpg,png,pdf',
            'issue_date' => 'required|date_format:d/m/Y|after_or_equal:01/03/2017|before_or_equal:',
            'value' => 'required|regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'payment_type_id' => 'required|integer|exists:payment_types,id',
            'description' => 'required|string|max:255',
            'note' => 'string|max:255',
            'original_name' => 'required|string|max:255'
	   ],
        ValidatorInterface::RULE_UPDATE => [
            'user_id' => 'required|integer|exists:users,id',
            'request_id' => 'integer|nullable',
            'project_id' => 'integer|nullable',
            'invoice' => 'required|min:1|max:6',
            'invoice_file' => 'mimes:jpeg,jpg,png,pdf',
            'issue_date' => 'required|date_format:d/m/Y|after_or_equal:01/03/2017|before_or_equal:',
            'value' => 'required|regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'payment_type_id' => 'required|integer|exists:payment_types,id',
            'description' => 'required|string|max:255',
            'note' => 'string|max:255',
            'original_name' => 'string|max:255'
	   ],
   ];
}