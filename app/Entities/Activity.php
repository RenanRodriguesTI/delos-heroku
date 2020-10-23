<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class Activity extends AbstractAudit
{
    use SoftDeleteWithRestoreTrait, RelationshipsTrait;

    protected $fillable = [
        'date',
        'hours',
        'project_id',
        'user_id',
        'task_id',
        'place_id',
        'note',
        'approved',
        'weekend',
        'approver_id',
        'concluded',
        'reason'
    ];
    protected $casts = [
        'date' => 'datetime',
        'approved' => 'boolean',
        'weekend' => 'boolean',

    ];
    protected $dates = ['deleted_at'];

	public function project()
	{
		return $this->belongsTo(Project::class)->withTrashed();
	}

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function approver()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function setNoteAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['note'] = $value;
        }
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->toDateString();
    }

    public static function sumHoursByUserIdAndDate(int $userId, Carbon $date) : int
    {
        $sum = static::query()
            ->withoutGlobalScopes()
            ->where('user_id', $userId)
            ->where('date', $date->toDateString())
            ->sum('hours');

        return $sum;
    }
}