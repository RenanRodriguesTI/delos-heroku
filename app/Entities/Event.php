<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 28/07/17
 * Time: 15:10
 */

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Illuminate\Database\Eloquent\Builder;

class Event extends AbstractAudit
{
    use RelationshipsTrait;

    protected $fillable = [
        'name',
        'description',
        'group_company_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->whereHas('company', function (Builder $query) {
            $query->whereIn('id', session('companies'));
        });
    }

    public function getUsersByCompanies(array $companies)
    {
        return $this->whereHas('users.company', function (Builder $query) use ($companies) {
            $query->whereIn('id', $companies);
        });
    }
}