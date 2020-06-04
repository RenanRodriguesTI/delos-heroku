<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SupplierExpensesImports extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id',
        'project_code',
        'issue_date',
        'value',
        'provider_id',
        'status',
        'description',
        'date_migration'
    ];

    protected $casts = [
        'date_migration' => 'datetime',
        'issue_date' => 'datetime',
        'value' => 'float'
    ];

    public function setIssueDateAttribute($value){
        $date = Carbon::createFromFormat('d/m/Y',$value);

        $this->attributes['issue_date'] = $date;
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
}
