<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/07/17
 * Time: 16:00
 */

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class GroupCompany extends AbstractAudit
{
    use SoftDeleteWithRestoreTrait, RelationshipsTrait;

    protected $fillable = [
        'name',
        'plan_id',
        'billing_date',
        'signature_date',
        'is_defaulting',
        'plan_status'
    ];

    protected $dates = [
        'billing_date',
        'signature_date',
    ];

    protected $casts = [
        'is_defaulting' => 'boolean',
        'plan_status' => 'boolean',
        'plan_id' => 'integer'
    ];

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function financialRatings()
    {
        return $this->hasMany(FinancialRating::class);
    }

    public function projectTypes()
    {
        return $this->hasMany(ProjectType::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function paymentInformation()
    {
        return $this->hasOne(PaymentInformation::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}