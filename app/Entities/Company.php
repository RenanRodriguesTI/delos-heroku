<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Company extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['name', 'group_company_id'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }
}