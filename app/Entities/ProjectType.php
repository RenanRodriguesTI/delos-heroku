<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class ProjectType extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = ['name', 'group_company_id'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }
}