<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class DebitMemo extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['finish_at', 'number'];

    protected $casts = [
        'number' => 'integer'
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class)->withTrashed();
    }

    public function alerts() {
        return $this->hasMany(DebitMemoAlert::class);
    }

    public function getCodeAttribute()
    {
        return sprintf('%04d', $this->number);
    }

    public function getValueTotalAttribute()
    {
        $value = $this->expenses
            ->map(function ($item) {
                $value = $item->value;

                if (strpos($value, '.') !== false) {
                    $value = str_replace('.', '', $value);
                }

                return ['value' => str_replace(',', '.', $value)];
            })->sum('value');

        return number_format($value, 2, ',', '.');
    }

    public function getValueTotalWithoutMaskAttribute()
    {
        $value = $this->expenses
            ->map(function ($item) {
                $value = $item->value;

                if (strpos($value, '.') !== false) {
                    $value = str_replace('.', '', $value);
                }

                return ['value' => str_replace(',', '.', $value)];
            })->sum('value');

        return $value;
    }

    public function getProjectAttribute()
    {
        return $this->expenses->first()->project;
    }

    public function getStatusAttribute(): string
    {
        $isFinish = $this->finish_at;

        return !$isFinish ? 'true' : 'false';
    }
}