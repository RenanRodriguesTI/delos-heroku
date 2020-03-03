<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Holiday extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['description', 'date'];
    protected $dates = ['deleted_at', 'created_at', 'date'];

    public function setDescriptionAttribute($value)
    {
    	$this->attributes['description'] = mb_strtoupper($value);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value);
    }
}
