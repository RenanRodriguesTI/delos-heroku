<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\AllocationRepository;
use Delos\Dgp\Services\AllocationService;
use Delos\Dgp\Repositories\Contracts\TaskRepository;

class AutoAllocationUpdateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $now = Carbon::now()->format('d/m/Y');
        $before = $event->before;
        $after = $event->after;
        $hours = $after->budget % 5 == 0 ? $after->budget * 0.05: (int)($after->budget / 5) + 1; 

        $allocation = app(AllocationRepository::class)
            ->scopeQuery(function ($query) use ($before, $after) {
                return $query->where('project_id', $before->id)
                    ->where('automatic', true)
                    ->where('start', $before->start->format('Y-m-d'))
                    ->where('finish', $before->finish->format('Y-m-d'))
                    ->whereNull('parent_id');
            })->first();

        if ($allocation) {
            $date = $after->extension;

            if($date){
                $date =  $after->finish->lessThan($after->extension) ? $after->extension : $after->finish;
            } else{
                $date = $after->finish;
            }
            $allocations = app(AllocationService::class)->updateGenerate([
                'project_id' => $allocation->project_id,
                'user_id' => $allocation->user_id,
                'group_company_id' => $allocation->user->group_company_id,
                'start' => $now,
                'finish' => $date->format('d/m/Y'),
                'hours' => $hours ,
                'hourDay' => 8,
                'automatic' => true
            ], $allocation->id);


            app(AllocationService::class)->deleteAllTask($allocations->first()->parent_id,true);


            app(AllocationService::class)->createTask([
                'task_id' => app(TaskRepository::class)->findByField('name', 'controle de projetos')->first()->id,
                'hours' => $hours,
            ], $allocations->first()->parent_id);
        }
    }
}
