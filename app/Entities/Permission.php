<?php

namespace Delos\Dgp\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Permission extends AbstractAudit
{
    use Sluggable, RelationshipsTrait;

    protected $fillable = ['name', 'id'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
