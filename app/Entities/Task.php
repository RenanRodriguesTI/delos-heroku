<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Task extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['name', 'group_company_id'];

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTrashed();
    }

    public function activities()
    {
        return $this->hasMany(Activity::class)->withTrashed();
    }

    public function projectTypes()
    {
        return $this->belongsToMany(ProjectType::class);
    }

    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}