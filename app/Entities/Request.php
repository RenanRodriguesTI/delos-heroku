<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Illuminate\Database\Eloquent\Builder;

class Request extends AbstractAudit
{
	use SoftDeleteWithRestoreTrait, RelationshipsTrait;

    protected $fillable = [
		'requester_id',
        'project_id',
        'parent_id',
        'approved',
        'reason',
        'start',
        'finish',
        'debit_memo_id',
        'approver_id',
        'notes'
	];

	protected $casts = [
		'requester_id' => 'integer',
		'project_id' => 'integer',
		'parent_id' => 'integer',
		'approved' => 'boolean',
        'debit_memo_id' => 'integer'
	];

	protected $dates = [
        'start',
        'finish',
    ];


	public function parent()
	{
		return $this->belongsTo(Request::class);
	}

	public function children()
	{
		return $this->hasMany(Request::class, 'parent_id');
	}

	public function users()
	{
		return $this->belongsToMany(User::class)->withTrashed();
	}

	public function requester()
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

	public function approver()
	{
		return $this->belongsTo(User::class)->withTrashed();
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class);
	}

	public function car()
	{
		return $this->hasOne(Car::class);
	}

	public function lodging()
	{
		return $this->hasOne(Lodging::class);
	}

	public function extraExpenses()
	{
		return $this->hasMany(ExtraExpense::class);
	}

	public function project()
	{
		return $this->belongsTo(Project::class)->withTrashed();
	}

	public function expenses()
	{
        return $this->hasMany(Expense::class);
	}

	public function debitMemo()
    {
        return $this->belongsTo(DebitMemo::class);
    }

	public function scopeOnlyParents(Builder $builder)
	{
		$builder->where('parent_id', null);
	}

	public function scopeUnapproved(Builder $builder)
	{
		$builder->onlyParents()->where('approved', false);
	}

    public function setStartAttribute($value)
    {
        $value = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['start'] = $value->format('Y-m-d');
    }

    public function setFinishAttribute($value)
    {
        $value = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['finish'] = $value->format('Y-m-d');
    }
}
