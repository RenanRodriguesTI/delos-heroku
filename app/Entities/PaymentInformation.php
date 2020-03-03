<?php

namespace Delos\Dgp\Entities;

class PaymentInformation extends AbstractAudit
{
    protected $fillable = [
        'name',
        'telephone',
        'email',
        'document',
        'is_bank_slip',
        'credit_card',
        'address',
        'group_company_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_bank_slip' => 'boolean',
        'credit_card' => 'json',
        'address' => 'json',
        'document' => 'json',
    ];

    public function groupCompany() {
        return $this->belongsTo(GroupCompany::class);
    }
}
