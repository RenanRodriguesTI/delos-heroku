<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class DebitMemoAlert extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
        'value',
        'debit_memo_id',
        'user_id'
    ];
    protected $casts = [
        'value' => 'float',
        'debit_memo_id' => 'integer',
        'user_id' => 'integer',

    ];
    protected $dates = ['created_at', 'updated_at'];

	public function debitMemo()
	{
		return $this->belongsTo(DebitMemo::class);
	}

    public function user()
    {
        return $this->belongsTo(User::class);
	}

    public function setValueAttribute($value)
    {
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
        $float = $numberFormatter->parse($value);
        $this->attributes['value'] = $float;
    }

    public function getValueAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getValueWithoutMaskAttribute($value)
    {
        return $value;
    }
}