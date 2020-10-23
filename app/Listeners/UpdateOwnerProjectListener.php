<?php

namespace Delos\Dgp\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Delos\Dgp\Services\AllocationService;
use Delos\Dgp\Repositories\Contracts\AllocationRepository;
use Carbon\Carbon;
use Delos\Dgp\Repositories\Contracts\TaskRepository;
use Delos\Dgp\Entities\AllocationTask;

class UpdateOwnerProjectListener
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
        $control = false;
        $allocation =  app(AllocationRepository::class)
        ->scopeQuery(function ($query) use ($before) {
            return $query->where('project_id', $before->id)
                ->where('automatic',true)
                ->whereNull('parent_id')
                ->orderBy('start','desc');
        })->first();


        // $allocation = $allocation  ?? app(AllocationRepository::class)
        //     ->scopeQuery(function ($query) use ($before, $date) {
        //         return $query->where('project_id', $before->id)
        //             ->where('start','<=', $before->start->format('Y-m-d'))
        //             ->where('finish','>=', $date->format('Y-m-d'))
        //             ->whereNull('parent_id')
        //             ->orderBy('start','desc');
        //     })->first();
        

        if ($allocation) {
            foreach ($allocation->allocationTasks as $allocationTask) {
                if (strtoupper($allocationTask->task->name) == 'CONTROLE DE PROJETOS') {
                    $control = true;
                    break;
                }
            }
        }

        if ($control) {
            //$allocation->finish = $now;

            $date = $after->extension;

            if ($date) {
                $date =  $after->finish->lessThan($after->extension) ? $after->extension : $after->finish;
            } else {
                $date = $after->finish;
            }

            $bubgetRemain = $allocation->children->filter(function ($item) use ($now) {
                return $item->start->greaterThan(Carbon::createFromFormat('d/m/Y', $now)) ||
                    Carbon::createFromFormat('d/m/Y', $now)->equalTo($item->start);
            })->sum('hours');

            $bubgetUsed = $allocation->children->filter(function ($item) use ($now) {
                return $item->start->lessThan(Carbon::createFromFormat('d/m/Y', $now));
            })->sum('hours');


            $allocationsOld = app(AllocationService::class)->updateGenerate([
                'project_id' => $allocation->project_id,
                'user_id' => $allocation->user_id,
                'group_company_id' => $allocation->user->group_company_id,
                'start' => $allocation->start->format('d/m/Y'),
                'finish' => $now,
                'hours' => $bubgetUsed,
                'hourDay' => 8,
                'automatic' => true
            ], $allocation->id);

            app(AllocationService::class)->deleteAllTask($allocationsOld->first()->parent_id, true);


            app(AllocationService::class)->createTask([
                'task_id' => app(TaskRepository::class)->findByField('name', 'controle de projetos')->first()->id,
                'hours' => $bubgetUsed,
            ], $allocationsOld->first()->parent_id,true);


            $allocationsNew = app(AllocationService::class)->generate([
                'project_id' => $after->id,
                'user_id' => $after->owner_id,
                'group_company_id' => $after->owner->group_company_id,
                'start' => $now,
                'finish' => $date->format('d/m/Y'),
                'hours' => $bubgetRemain,
                'hourDay' => 8,
                'automatic' => true
            ]);

            app(AllocationService::class)->createTask([
                'task_id' => app(TaskRepository::class)->findByField('name', 'controle de projetos')->first()->id,
                'hours' => $bubgetRemain,
            ], $allocationsNew->first()->parent_id,true);
        }
    }
}
