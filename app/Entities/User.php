<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordInterface;
use Illuminate\Mail\Message;
use Illuminate\Notifications\Notifiable;
use Mail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;
use  Carbon\CarbonInterval;
use Delos\Dgp\Services\RangeTrait;
use Delos\Dgp\Services\WorkingDay;
use Exception;

class User extends AbstractAudit implements CanResetPasswordInterface
{
    use SoftDeleteWithRestoreTrait, CanResetPasswordTrait, Notifiable, RelationshipsTrait, HasApiTokens, RangeTrait, WorkingDay;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admission',
        'role_id',
        'overtime',
        'supplier_number',
        'company_id',
        'reported_external_activities',
        'account_number',
        'is_partner_business',
        'avatar',
        'office',
        'group_company_id',
        'notes',
        'color'
    ];

    protected $casts = [
        'admission'                    => 'datetime',
        'overtime'                     => 'integer',
        'role_id'                      => 'integer',
        'reported_external_activities' => 'datetime',
        'is_partner_business'          => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }

    public function missingActivities()
    {
        return $this->hasMany(MissingActivity::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function owningProjects()
    {
        return $this->hasMany(Project::class, 'owner_id')
            ->onlyTrashed();
    }

    public function requests()
    {
        return $this->belongsToMany(Request::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function epiUser()
    {
        return $this->hasMany(EpiUser::class);
    }

    public function groupCompany()
    {
        return $this->belongsTo(GroupCompany::class);
    }

    public function debitMemoAlert()
    {
        return $this->hasOne(DebitMemoAlert::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    public function coasts()
    {
        return $this->hasMany(CoastUser::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contracts::class);
    }

    public function curses()
    {
        return $this->hasMany(Curse::class);
    }


    public function isOwnerOrCoOwner($projectId)
    {

        $project = Project::find($projectId);

        if ($project == null) {
            return false;
        }

        if ($this->id == $project->owner->id || (!is_null($project->coOwner) && $this->id == $project->coOwner->id)) {

            return true;
        }

        return false;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    public function setAdmissionAttribute($value)
    {
        $format = '';

        $ABNTDatePattern = '/^\d{2}\/\d{2}\/\d{4}$/';
        $ANSIDatePattern = '/^\d{4}-\d{2}-\d{2}$/';

        if (preg_match($ABNTDatePattern, $value) === 1) {
            $format = 'd/m/Y';
        } else if (preg_match($ANSIDatePattern, $value) === 1) {
            $format = 'Y-m-d';
        }

        if (!empty($format)) {
            $this->attributes['admission'] = Carbon::createFromFormat($format, $value);
        }
    }

    public function sendPasswordResetNotification($token)
    {
        Mail::send('auth.emails.password', [
            'user'  => $this,
            'token' => $token
        ], function (Message $message) {
            $message->to($this->email, $this->name);
            $message->subject(trans('subjects.reset-link'));
        });
    }

    public function getSummedHoursFromOwningProjectsAttribute(): int
    {
        $hoursSummed = 0;
        foreach ($this->owningProjects as $owningProject) {
            $hoursSummed += $owningProject->activitiesWithTrashed->where('approved', true)->sum('hours');
        }
        return $hoursSummed;
    }

    public function getCoastFromMonth(string $month, User $user)
    {
        $year = app('request')->cookie('year_coast_users');

        if (!$year) {
            $year = now()->year;
        }

        $coast = $user->coasts
            ->filter(function ($item, $key) use ($month, $year) {
                return (strcasecmp($month, $item->date->format('F')) == 0) && $year == $item->date->year;
            });

        return $coast->first();
    }

    public function userOffices()
    {
        return $this->hasMany(UserOffice::class);
    }

    public function getIdOfficeAttribute()
    {
        $userOffice = UserOffice::where('user_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return $userOffice ? $userOffice->office->id : 0;
    }

    public function getStartOfficeAttribute()
    {
        $office = UserOffice::where('user_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return $office ? $office->start : 0;
    }

    public function getPedingAllocations($projectId)
    {
        $pending = false;
        $allocations = $this->allocations->where('project_id', $projectId)
            ->where('parent_id', null);

        foreach ($allocations as $allocation) {
            if ($allocation->allocationTasks->isEmpty() && !$allocation->task_id) {
                $pending = true;
            }
        }

        return $pending;
    }


    public function getPedingActivities($projectId)
    {
        $activities = $this->activities->where('project_id', $projectId)
            ->where('approver_id', null);

        return !$activities->isEmpty();
    }

    public function hasTaskConcludes($projectId)
    {
        $concludes = false;
        $allocations = $this->allocations->where('project_id', $projectId)
            ->where('parent_id', null);

        foreach ($allocations as $allocation) {
            foreach ($allocation->allocationTasks as $allocationTask) {
                if ($allocationTask->concludes) {
                    $concludes = true;
                }
            }
        }

        return $concludes;
    }


    public function getHaveExpiredDocumentsAttribute()
    {
        $epis = $this->epiUser;
        $curses = $this->curses;
        $expired = false;
        $now = Carbon::now();

        foreach ($epis as $epi) {
            if ($epi->shelf_life) {
                $expired = $now->greaterThan($epi->shelf_life);
            }
        }

        foreach ($curses as $curse) {
            if ($curse->end_date && !$expired) {
                $expired = $now->greaterThan($curse->end_date);
            }
        }
        return $expired;
    }

    public function getHours()
    {
        try {
            $start = Carbon::createFromFormat('d/m/Y', app('request')->input('start'));
            $finish = Carbon::createFromFormat('d/m/Y', app('request')->input('finish'));

            $preview = 8*$this->countWorkDays(['start'=>app('request')->input('start'),'finish'=>app('request')->input('finish')]);
            $sum = DB::select("SELECT COALESCE(SUM(hours),0) as hours FROM allocation_tasks 
            where allocation_id in (SELECT ID FROM allocations WHERE parent_id is null and user_id = :user) 
            and start >= :start and finish <= :finish", [
                'start' => $start->format('Y-m-d'),
                'finish' => $finish->format('Y-m-d'),
                'user' => $this->id
            ]);

            return ($preview - $sum[0]->hours <0) ? 0: $preview - $sum[0]->hours;
        } catch (Exception $err) {
            return 0;
        }
    }


    public function getSituationResourceAttribute(){
        try{
            $start = Carbon::createFromFormat('d/m/Y', app('request')->input('start'));
            $finish = Carbon::createFromFormat('d/m/Y', app('request')->input('finish'));
            $preview = 8*$this->countWorkDays(['start'=>app('request')->input('start'),'finish'=>app('request')->input('finish')]);
            $sum = DB::select("SELECT COALESCE(SUM(hours),0) as hours FROM allocation_tasks 
            where allocation_id in (SELECT ID FROM allocations WHERE parent_id is null and user_id = :user) 
            and start >= :start and finish <= :finish", [
                'start' => $start->format('Y-m-d'),
                'finish' => $finish->format('Y-m-d'),
                'user' => $this->attributes['id']
            ]);


            if($sum[0]->hours ==0){
                return "avaliable";
            }else{
                if($preview > $sum[0]->hours){
                    return "partial";
                } else{
                    return "unavaliable";
                }
            }


        } catch(Exception $err){
            return "avaliable";
        }
    }

    public function getHasDetailsAttribute(){
        try{

            $start = app('request')->input('start');
            $finish = app('request')->input('finish');

            if($start && $finish){
               $result = DB::SELECT("SELECT COALESCE(COUNT(id),0) countTask FROM allocation_tasks
            where allocation_id in (SELECT ID FROM allocations WHERE parent_id is null and user_id =:user) 
            and allocation_tasks.start >= STR_TO_DATE(:start,'%d/%m/%y') and allocation_tasks.finish <= STR_TO_DATE(:finish,'%d/%m/%y')",
            [
                'start' => $start,
                'finish' => $finish,
                'user' => $this->attributes['id']
            ]
            );
                return $result[0]->countTask >0;
            }

            return false;

            
        } catch(Exception $err){
            return false;
        }
    }


    private function countWorkDays(array $data): int
    {
        $quantity   = 0;
        $diffInDays = $this->getDateRange($data['start'], $data['finish']);
        foreach ($diffInDays as $day) {
            if ($this->isWorkingDay($day)) {
                $quantity++;
            }
        }
        return $quantity;
    }
}
