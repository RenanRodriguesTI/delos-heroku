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
    class User extends AbstractAudit implements CanResetPasswordInterface
    {
        use SoftDeleteWithRestoreTrait, CanResetPasswordTrait, Notifiable, RelationshipsTrait, HasApiTokens;
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
            'group_company_id',
            'notes',
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

        public function users(){
            return $this->hasMany(Contracts::class);
        }

        public function isOwnerOrCoOwner($projectId)
        {

            $project = Project::find($projectId);

            if ( $project == null ) {
                return false;
            }

            if ( $this->id == $project->owner->id || (!is_null($project->coOwner) && $this->id == $project->coOwner->id) ) {

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

            if ( preg_match($ABNTDatePattern, $value) === 1 ) {
                $format = 'd/m/Y';
            }
            else if ( preg_match($ANSIDatePattern, $value) === 1 ) {
                $format = 'Y-m-d';
            }

            if ( !empty($format) ) {
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
            foreach ( $this->owningProjects as $owningProject ) {
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
    }
