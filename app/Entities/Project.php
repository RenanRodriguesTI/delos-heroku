<?php

    namespace Delos\Dgp\Entities;

    use Carbon\Carbon;
    use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

    class Project extends AbstractAudit
    {
        use SoftDeleteWithRestoreTrait, RelationshipsTrait;

        protected $fillable = [
            'cod',
            'description',
            'project_type_id',
            'compiled_cod',
            'financial_rating_id',
            'budget',
            'owner_id',
            'co_owner_id',
            'proposal_value',
            'proposal_number',
            'start',
            'finish',
            'company_id',
            'notes',
            'extra_expenses',
            'services_providers',
            'client_id',
            'seller_id',
            'commission',
            'date_nf',
            'date_received',
            'os',
            'date_change',
            'nf_nd',
            'expected_date',
            'extension'
        ];

        protected $casts = [
            'owner_id' => 'integer',
            'co_owner_id' => 'integer',
            'client_id' => 'integer',
            'seller_id' => 'integer',
        ];

        protected $dates = [
            'deleted_at',
            'start',
            'finish',
            'last_activity',
            'date_nf',
            'date_received',
            'date_change',
            'expected_date',
            'extension'
        ];

        public function getSpentHours()
        {
            return $this->activities->where('approved', true)
                                    ->sum('hours');
        }

        public function setCoOwnerIdAttribute($value)
        {
            $this->attributes['co_owner_id'] = empty($value) ? null : $value;
        }

        public function client()
        {
            return $this->belongsTo(User::class);
        }

        public function financialRating()
        {
            return $this->belongsTo(FinancialRating::class);
        }

        public function proposalValueDescriptions()
        {
            return $this->hasMany(ProjectProposalValue::class)
                        ->withTrashed();
        }

        public function owner()
        {
            return $this->belongsTo(User::class)
                        ->withTrashed();
        }

        public function coOwner()
        {
            return $this->belongsTo(User::class)
                        ->withTrashed();
        }

        public function seller()
        {
            return $this->belongsTo(User::class)
                ->withTrashed();
        }

        public function clients()
        {
            return $this->belongsToMany(Client::class);
        }

        public function members()
        {
            return $this->belongsToMany(User::class)->withPivot('hours');
        }

        public function activities()
        {
            return $this->hasMany(Activity::class)
                        ->withTrashed();
        }

        public function activitiesWithTrashed()
        {
            return $this->hasMany(Activity::class)
                        ->withTrashed();
        }

        public function tasks()
        {
            return $this->belongsToMany(Task::class)
                        ->withPivot('hour');
        }

        public function projectType()
        {
            return $this->belongsTo(ProjectType::class);
        }

        public function company()
        {
            return $this->belongsTo(Company::class);
        }

        public function requests()
        {
            return $this->hasMany(Request::class);
        }

        public function expenses()
        {
            return $this->hasMany(Expense::class)
                        ->withTrashed();
        }

        public function providerExpenses(){
            return $this->hasMany(SupplierExpenses::class);
        }

        public function allocations()
        {
            return $this->hasMany(Allocation::class);
        }

        public function contracts(){
            return $this->belongsToMany(Contracts::class,'contract_project');
        }

        public function getHoursPercentage()
        {
            try {
                return $this->getSpentHours() / $this->budget * 100;
            } catch ( \ErrorException $e ) {
                return 0;
            }
        }

        public function setStartAttribute($value)
        {
            $this->attributes['start'] = Carbon::createFromFormat('d/m/Y', $value)
                                               ->toDateString();
        }

        public function setFinishAttribute($value)
        {
            $this->attributes['finish'] = Carbon::createFromFormat('d/m/Y', $value)
                                                ->toDateString();
        }

        public function setExtensionAttribute($value){
            $this->attributes['extension'] = Carbon::createFromFormat('d/m/Y', $value);
        }

        public function setSellerIdAttribute($value)
        {
            if ($value === '') {
                $value = null;
            }

            $this->attributes['seller_id'] = $value;
        }

        public function getFullDescriptionAttribute()
        {
            return $this->compiled_cod . ' - ' . $this->description;
        }

        public function getSummedActivity($model)
        {
            $activities = $model->activitiesWithTrashed->filter(function ($item) {
                return $item->deleted_at !== null;
            });

            return $activities->sum('hours');
        }

        public function setDateNfAttribute($value){
            $this->attributes['date_nf'] = Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString();
        }

        public function setDateReceivedAttribute($value){
            $this->attributes['date_received'] = Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString();
        }

        public function setDateChangeAttribute($value){
            $this->attributes['date_change'] = Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString();
        }

        public function setExpectedDateAttribute($value){
            $this->attributes['expected_date'] = Carbon::createFromFormat('d/m/Y', $value)
            ->toDateString();
        }
    }