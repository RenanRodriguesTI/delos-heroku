<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/10/17
 * Time: 15:45
 */

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Illuminate\Support\Facades\Storage;

class PaymentTransaction extends AbstractAudit
{
    protected $fillable = [
        'billing_date',
        'payday',
        'status',
        'value_paid',
        'group_company_id',
    ];

    protected $dates = [
        'billing_date',
        'payday',
        'created_at',
        'updated_at'
    ];

    public function getUrlAttribute()
    {
        return Storage::url($this->getFullPath($this));
    }

    public function getDueDateAttribute()
    {
        $dueDate = Carbon::createFromFormat('Y-m-d', $this->attributes['billing_date']);
        return $this->getDueDateToBankSlip($dueDate)->format('d/m/Y');
    }

    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }

    public function setValuePaidAttribute($value)
    {
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
        $float = $numberFormatter->parse($value);
        $this->attributes['value_paid'] = $float;
    }

    private function getDueDateToBankSlip($date): Carbon
    {
        $date = $date->addDay(3);
        $holidays = $this->getHolidays();

        while ($holidays->contains($date->format('Y-m-d'))) {
            $date->addDay();
        }

        if ($date->isWeekend()) {
            if ($date->isSaturday()) {
                $date->addDay(2);
            }

            if ($date->isSunday()) {
                $date->addDay(1);
            }
        }

        return $date;
    }

    private function getHolidays()
    {
        $holidays = app(HolidayRepository::class)->pluck('date')->map(function ($item) {
            return $item->format('Y-m-d');
        });
        return $holidays;
    }

    private function getFullPath($paymentTransaction): string
    {
        return 'Pdfs/' . $paymentTransaction->groupCompany->id . '/' . Carbon::now()->month . '/' . $paymentTransaction->id . '.pdf';
    }
}