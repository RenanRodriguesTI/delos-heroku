<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Client extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
        'cod',
        'name',
        'telephone',
        'email',
        'document',
        'address',
        'group_id',
        'group_company_id'
    ];

    protected $casts = [
        'group_id' => 'integer',
        'address' => 'json',
        'document' => 'json',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function proposalValueDescriptions()
    {
        return $this->belongsToMany(ProjectProposalValue::class);
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
