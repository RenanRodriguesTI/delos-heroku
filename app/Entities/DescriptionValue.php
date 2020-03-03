<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class DescriptionValue extends AbstractAudit
{
    use SoftDeleteWithRestoreTrait, RelationshipsTrait;

    protected $fillable = [
        'project_id',
        'description',
        'month',
        'value',
        'has_billed',
        'invoice_number',
        'notes',
        'created_at',
        'update_at',
        'deleted_at'
    ];

    protected $casts = [
        'project_id' => 'integer',
        'value'      => 'float'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'update_at',
        'month'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function setMonthAttribute($value) {
        $month = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['month'] = $month;
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}