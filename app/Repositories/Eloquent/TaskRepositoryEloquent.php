<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Task;
use Delos\Dgp\Repositories\Contracts\TaskRepository;
use Delos\Dgp\Presenters\TaskPresenter;

class TaskRepositoryEloquent extends BaseRepository implements TaskRepository
{
    protected $fieldSearchable = [
        'name' => 'like'
    ];

    public function boot()
    {
        $this->orderBy('name', 'asc');
        parent::boot();
    }

    public function model()
    {
        return Task::class;
    }

    public function presenter()
    {
        return TaskPresenter::class;
    }

    public function getTasksPairsByProjectId(int $projectId): iterable
    {
        $repo = $this->whereHas('projects', function($query) use($projectId) {
            return $query->where('project_id', $projectId);
        });

        return $repo->pluck('name', 'id')->toArray();
    }

}