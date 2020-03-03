<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Carbon\Carbon;
use Delos\Dgp\Entities\Activity;
use Delos\Dgp\Presenters\ActivityPresenter;
use Delos\Dgp\Repositories\Contracts\ActivityRepository;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Delos\Dgp\Repositories\Contracts\RequestRepository;
use Delos\Dgp\Repositories\Criterias\Activity\ScopeCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

class ActivityRepositoryEloquent extends BaseRepository implements ActivityRepository
{
    private const ABSENCE_TASK_NAME = 'AUSÊNCIA';
    private const ADMINISTRATIVE_PROJECT_TYPE_NAME = 'Administrativo';

    protected $fieldSearchable = [
        'user.name' => 'like',
        'user.email' => 'like',
        'project.projectType.name' => 'like',
        'project.compiled_cod' => 'like',
        'task.name' => 'like',
        'note' => 'like',
        'place.name' => 'like'
    ];

    public function boot()
    {
        parent::boot();
        $this->popCriteria(RequestCriteria::class);
        $this->pushCriteria(new ScopeCriteria());
    }

    public function model()
    {
        return Activity::class;
    }

    public function presenter()
    {
        return ActivityPresenter::class;
    }

    public function sumApprovedHoursByProjectId(int $projectId): int
    {
        $hours = $this->model
            ->where('project_id', $projectId)
            ->where('approved', true)
            ->sum('hours');

        return $hours;
    }

    public function sumApprovedHoursByUserId(int $userId): int
    {
        $hours = $this->model
            ->withTrashed()
            ->where('user_id', $userId)
            ->whereNotNull('project_id')
            ->where('approved', true)
            ->sum('hours');

        return $hours;
    }

    public function sumHoursByUserIdAndDate(int $userId, Carbon $date): int
    {
        $activities = $this->model->withTrashed()
            ->where('date', $date->toDateString())
            ->where('user_id', $userId);

        return $activities->sum('hours');
    }

    public function getAbsencesCreatedSinceLastMonday(): iterable
    {
        $repo = $this->whereHas('task', function ($query) {
            return $query->where('name', self::ABSENCE_TASK_NAME);
        });

        $repo = $repo->whereHas('project', function ($query) {
            return $query->whereHas('projectType', function ($query) {
                return $query->where('name', self::ADMINISTRATIVE_PROJECT_TYPE_NAME);
            });
        });

        $lastMonday = new Carbon('last monday');
        $absences = $repo->findWhere([
            ['created_at', '>=', $lastMonday->toDateString()]
        ]);

        return $absences;
    }

    public function countWaitingToBeApprovedByUserId(int $userId): int
    {
        $this->applyCriteria();

        $model = $this->model->where('approved', false)
            ->where('user_id', $userId);

        return $model->count();
    }

    public function getExternalWorksLastMonthForListing(): iterable
    {
        $activities = [];

        $requests = $this->getRequestsOnLastMonth();

        foreach ($requests as $request) {
            foreach ($request->users as $user) {
                $activitiesByUserIdAndProjectId = $this->getActivitiesByCheckInAndCheckOutLodging($user, $request);

                if ($this->countDates($activitiesByUserIdAndProjectId) > 0) {
                    $data = [
                        'project' => $request->project->full_description,
                        'request_number' => $request->id,
                        'user' => $user->name,
                        'start' => $activitiesByUserIdAndProjectId->first()->date->format('d/m/Y'),
                        'finish' => $activitiesByUserIdAndProjectId->last()->date->format('d/m/Y'),
                        'total' => $this->countDates($activitiesByUserIdAndProjectId)
                    ];

                    array_push($activities, $data);
                }
            }
        }

        return $activities;
    }

    private function countDates($activities): int
    {
        $last = "";
        $count = 0;

        foreach ($activities as $activity) {
            if ($activity->date->format('Y-m-d') <> $last) {
                $count++;
            }
            $last = $activity->date->format('Y-m-d');
        }

        return $count;
    }

    private function getRequestsOnLastMonth()
    {
        $firstDayLastMonth = (new Carbon('first day of last month'))->format('Y-m-d');
        $lastDayLastMonth = Carbon::now()->format('Y-m-d');

        $requestRepository = app(RequestRepository::class);
        $requests = [];

        $requestsLastMonth = $requestRepository->model->
            withTrashed()
            ->with('children.lodging', 'project')
            ->whereBetween('start', [$firstDayLastMonth, $lastDayLastMonth])
            ->orWhereBetween('finish', [$firstDayLastMonth, $lastDayLastMonth])
            ->get();

        foreach ($requestsLastMonth as $request) {
            if ($request->children->first()->lodging) {
                array_push($requests, $request);
            }
        }

        return $requests;
    }

    private function getActivitiesByCheckInAndCheckOutLodging($user, $request)
    {
        $checkIn = $request->children->first()->lodging->check_in->format('Y-m-d');
        $checkout = $request->children->first()->lodging->checkout->format('Y-m-d');

        return $this->model->withTrashed()
            ->where('user_id', $user->id)
            ->where('project_id', $request->project->id)
            ->where('place_id', 2)
            ->whereBetween('date', [$checkIn, $checkout])
            ->orderBy('date', 'asc')
            ->get();
    }

    private function getHolidays()
    {
        return app(HolidayRepository::class)->pluck('date')
            ->transform(function ($holiday) {
                return $holiday->toDateString();
            })->toArray();
    }
}
