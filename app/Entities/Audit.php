<?php

namespace Delos\Dgp\Entities;


use OwenIt\Auditing\Models\Audit as AuditModel;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;


class Audit extends AuditModel
{
    use RelationshipsTrait;


    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}