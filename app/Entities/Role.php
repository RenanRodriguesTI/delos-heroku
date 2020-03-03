<?php

namespace Delos\Dgp\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Role extends AbstractAudit
{
    use Sluggable, RelationshipsTrait;

    protected $fillable = [
		'name'
	];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
