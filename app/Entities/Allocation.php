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
            'hourDay',
            'description',
            'reason',
            'status',
            'parent_id',
            'jobWeekEnd',
            'automatic'
        ];

        private $color ='';

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

        public function allocationTasks(){
            return $this->hasMany(AllocationTask::class);
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
            if(!$this->allocationTasks->isEmpty()){
                return "{$this->project->compiled_cod} - {$this->user->name} - Multiplas Tarefas";
            }
            if(!$this->task){
                return "{$this->project->compiled_cod} - {$this->user->name} - Não Especificado";
            }
            return "{$this->project->compiled_cod} - {$this->user->name} - {$this->task->name}";
        }


        public function getHoursAvailableAttribute(){
            if($this->task){
                return 0;
            }
            
            if($this->allocationTasks){
                $used = $this->allocationTasks->sum('hours');
                return ($this->hours - $used);
            }

            return $this->hours;
        }

        public function getHoursUsedAttribute(){
            if($this->task){
                return $this->hours;
            }

            if($this->allocationTasks){
                return $this->allocationTasks->sum('hours');
            }

            return 0;
        }

        public function getColorAttribute(){
        $colors = explode(' ','#c8d769 #20c7ef #d4ed54 #3c8c40 #316320 #0eb2b0 #ea8e37 #16aa46 #448899 #e4d41d #3ed505 #41a73f #310a99 #6eb50c #0dc4fa #FFC312 #F79F1F #009432 #33d9b2 #218c74 #474787 #f9ca24 #6ab04c #f19066 #546de5 #3dc1d3');
            $this->color= $colors[random_int(0,count($colors) - 1)];
            
           return  $this->color;
        }


        public function getCompiledTasksAttribute(){
            $tasks = collect();

            foreach($this->allocationTasks as $allocationTask){
                $tasks->push($allocationTask->task->name);
            }

            return implode(' - ',$tasks->unique()->toArray());
        }
    }