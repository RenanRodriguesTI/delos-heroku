<?php

namespace Delos\Dgp\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Delos\Dgp\Entities\AllocationTask;
use Delos\Dgp\Entities\Resource;
use Delos\Dgp\Services\RangeTrait;
use Delos\Dgp\Services\Api\WorkingDay;
use Exception;

class ResourceTaskAdded implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels,RangeTrait,WorkingDay;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     
    public $tries = 1;
    private $task;
    public function __construct(array $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = $this->countWorkDays($this->task);
        $preview = ceil($this->task['hours'] /$count);
        $hours = $this->task['hours'];
        $this->calculate($preview,$hours);
        
    }


    private function calculate($preview,$hours){
        $remain =0;
        $diffInDays = $this->getDateRange($this->task['start'], $this->task['finish']);
        foreach ($diffInDays as $day) {
            if ($this->isWorkingDay($day)) {
                $resource = Resource::where('user_id',$this->task['user_id'])->where('start',$day)->get()->sum('hours');
                $resource = $resource ? $resource : 0;
              if($preview + $resource <= 24){
                 Resource::create([
                     'start'=>$day->format('d/m/Y'),
                     'finish'=>$day->format('d/m/Y'),
                     'hours'=> $preview,
                     'allocation_task_id' =>$this->task['id'],
                     'user_id' => $this->task['user_id'],
                     'status'=>'partial'
                 ]);

                 $hours-=$preview;
              } else{
                 $remain=  $preview + $resource - 24;

                 Resource::create([
                    'start'=>$day->format('d/m/Y'),
                    'finish'=>$day->format('d/m/Y'),
                    'hours'=> $preview - $remain,
                    'allocation_task_id' =>$this->task['id'],
                    'user_id' => $this->task['user_id'],
                    'status'=>'partial'
                ]);

                $hours-= ($preview - $remain);
              }
            }
        }
        return $hours;
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

     public function failed(Exception $exception)
    {
        var_dump($exception);
    }

}
