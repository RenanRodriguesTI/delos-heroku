<?php

namespace Delos\Dgp\Validators;

use Carbon\Carbon;
use Illuminate\Validation\Factory;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SupplierExpensesValidator extends LaravelValidator
{
    private $today;
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'issue_date' => 'required|date_format:d/m/Y|after_or_equal:01/03/2017|before_or_equal:',
            'project_id' => 'required',
            'provider_id' => 'required|integer|exists:providers,id',
            'voucher_type_id' => 'required|integer|exists:voucher_types,id',
            'payment_type_provider_id' => 'required|integer|exists:payment_type_providers,id',
            'value' => 'required|regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'description_id' => 'required',
            'establishment_id' => 'required',
            'original_name' => 'required|string|max:255'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'issue_date' => 'required|date_format:d/m/Y|after_or_equal:01/03/2017|before_or_equal:',
            'project_id' => 'required',
            'provider_id' => 'required|integer|exists:providers,id',
            'voucher_type_id' => 'required|integer|exists:voucher_types,id',
            'payment_type_provider_id' => 'required|integer|exists:payment_type_providers,id',
            'value' => 'required|regex:/^\d+(.\d{3})?+(.\d{3})?+(.\d{3})?+(,\d{2})?$/',
            'description_id' => 'required',
            'establishment_id' => 'required',
            'original_name' => 'string|max:255'
        ],
    ];

    public function __construct(Factory $validator)
    {
        parent::__construct($validator);
        $this->today = (new Carbon('today'))->format('d/m/Y');
        $this->rules['create']['issue_date'] .= $this->today;
        $this->rules['update']['issue_date'] .= $this->today;
    }
}
