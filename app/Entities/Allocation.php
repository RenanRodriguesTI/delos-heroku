<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 18/04/18
     * Time: 10:52
     */

    namespace Delos\Dgp\Entities;

    use Carbon\Carbon;
    use DB;
    use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

    /**
     * Class Allocation
     * @package Delos\Dgp\Entities
     */
    class Allocation extends AbstractAudit
    {
        use RelationshipsTrait, SoftDeleteWithRestoreTrait;

        /**
         * @var array
         */
        protected $fillable = [
            'project_id',
            'user_id',
            'task_id',
            'group_company_id',
            'start',
            'finish',
            'hours',
            'description',
            'reason',
            'status',
            'parent_id'
        ];

        /**
         * @var array
         */
        protected $casts = [
            'group_company_id' => 'integer',
            'project_id'       => 'integer',
            'user_id'          => 'integer',
            'task_id'          => 'integer',
            'parent_id'        => 'integer'
        ];

        /**
         * @var array
         */
        protected $dates = [
            'start',
            'finish',
            'created_at',
            'updated_at',
            'deleted_at'
        ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function parent()
        {
            return $this->belongsTo(Allocation::class, 'parent_id');
        }

        public function children()
        {
            return $this->hasMany(Allocation::class, 'parent_id');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function project()
        {
            return $this->belongsTo(Project::class)
                        ->withTrashed();
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user()
        {
            return $this->belongsTo(User::class)
                        ->withTrashed();
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function task()
        {
            return $this->belongsTo(Task::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function groupCompany()
        {
            return $this->belongsTo(GroupCompany::class);
        }

        /**
         * Set Start field value to Carbon
         *
         * @param $value
         */
        public function setStartAttribute($value)
        {
            $this->attributes['start'] = Carbon::createFromFormat('d/m/Y', $value);
        }

        /**
         * Set Finish field value to Carbon
         *
         * @param $value
         */
        public function setFinishAttribute($value)
        {
            $this->attributes['finish'] = Carbon::createFromFormat('d/m/Y', $value);
        }

        public function getCompiledNameAttribute()
        {
            return "{$this->project->compiled_cod} - {$this->user->name} - {$this->task->name}";
        }
    }