<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 24/08/17
 * Time: 10:24
 */

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Module extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
        'name'
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}