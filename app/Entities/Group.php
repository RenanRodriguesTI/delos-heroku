<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Group extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['cod', 'name', 'group_company_id'];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value);
    }

    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }
}
