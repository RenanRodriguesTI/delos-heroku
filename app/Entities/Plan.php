<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 22/08/17
 * Time: 15:01
 */

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Plan extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
        'name',
        'billing_type',
        'periodicity',
        'value',
        'trial_period',
        'max_users',
        'description'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function groupCompanies()
    {
        return $this->hasMany(GroupCompany::class);
    }
}