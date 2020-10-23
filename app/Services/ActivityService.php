<?php

namespace Delos\Dgp\Services;

use Carbon\Carbon;
use Delos\Dgp\Entities\Activity;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Events\{ActivityOnWeekdayEvent, ActivityReproved, ActivityApproved};
use Delos\Dgp\Repositories\Eloquent\ActivityRepositoryEloquent;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\ConnectionInterface as Connection;
use Illuminate\Events\Dispatcher as Event;
use Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Support\Facades\DB;

class ActivityService extends AbstractService
{
    private const MAXIMUM_HOURS_PER_DAY = 8;

    use WorkingDay, RangeTrait;

    private $gate;

    public function __construct(ValidatorInterface $validator, Event $event, Connection $conn, Gate $gate)
    {
        parent::__construct($validator, $event, $conn);
        $this->gate = $gate;
    }

    public function repositoryClass(): string
    {
        return ActivityRepositoryEloquent::class;
    }

    public function create(array $data)
    {
        $this->validator->with($data)
            ->passesOrFail(ValidatorInterface::RULE_CREATE);

        $activities = collect();
        DB::beginTransaction();

        $usersIds = $data['user_id'];
        foreach ($usersIds as $userId) {

            $dateRange = $this->getDateRange($data['start_date'], $data['finish_date']);

            foreach ($dateRange as $day) {
                $data['user_id'] = $userId;
                $data = $this->transformActivity($day, $data);
                $activity = Activity::query()->create($data);
                $this->fireEventIfWorkingDay($activity);
                $activities->push($activity);
            }
        }
        DB::commit();

        return $activities;
    }

    public function approve($id)
    {
        $activity = Activity::query()
            ->withoutGlobalScopes()
            ->find($id);

        $activity->update(['approved' => true, 'approver_id' => auth()->id()]);

        $this->event->fire(new ActivityApproved($activity));

        return $activity;
    }

    public function reprove($id,array $data)
    {
        $data['reason'] = isset($data['reason'])? $data['reason']:'';
        $activity = Activity::query()
            ->withoutGlobalScopes()
            ->find($id);

        $activity->update([
            'approved' => false, 
            'approver_id' => auth()->id(),
            'reason' => $data['reason']
            ]);

        $this->event->fire(new ActivityReproved($activity));

        return $activity;
    }



    private function transformActivity(Carbon $activityDay,  array $data): array
    {
        $data['date'] = $activityDay->format('d/m/Y');
        $data['weekend'] = $this->isNonWorkingDay($activityDay);
        $project = Project::query()
            ->withoutGlobalScopes()
            ->find($data['project_id']);

        $data['approved'] = true;
        $data['approver_id'] = auth()->id();

        if ($project->client !== null || !$this->isWorkingDay($activityDay)) {
            $data['approved'] = false;
            $data['approver_id'] = null;
        }

        return $data;
    }

    private function fireEventIfWorkingDay(Activity $activity)
    {
        if ($this->isWorkingDay($activity->date)) {
            $this->event->fire(new ActivityOnWeekdayEvent($activity));
        }
    }

    public function getByProject(int $id, int $userId = 0)
    {
        $approvedFilter = app('request')->input('approved');
        $activities = $this->repository->scopeQuery(function ($query) use ($id, $approvedFilter, $userId) {
            if (count($approvedFilter) ==2) {
                return $query->with('project', 'user', 'place', 'task')->where('project_id', $id)
                ->where(function($query) use ($id, $userId){
                    return $query->where('project_id',$id)
                    ->where('user_id',$userId)
                    ->where('approved',false)
                    ->whereNull('approver_id');
                })
                ->orWhere(function($query) use ($id, $userId){
                    return $query->where('project_id',$id)
                    ->where('user_id',$userId)
                    ->where('approved',true);
                });
            }
            return $query->with('project', 'user', 'place', 'task')->where('project_id', $id)
                ->where('approved', (array_search('1',$approvedFilter) != NULL)?true:false)
                ->where('user_id', $userId)
                ->whereNull('approver_id')
                ->orderBy('date', 'desc');
        })->all();

        return $activities;
    }
}
