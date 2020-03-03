<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\MissingActivity;
use Delos\Dgp\Repositories\Contracts\MissingActivityRepository;
use Delos\Dgp\Presenters\MissingActivityPresenter;

class MissingActivityRepositoryEloquent extends BaseRepository implements MissingActivityRepository
{
    protected $fieldSearchable = [
        'user.name' => 'like',
        'user.email' => 'like',
        'user.role.name',
    ];

    public function model()
    {
        return MissingActivity::class;
    }

    public function presenter()
    {
        return MissingActivityPresenter::class;
    }

    public function sumHoursByUserId(int $userId) : int
    {
        $hours = $this->findWhere(['user_id' => $userId])->sum('hours');

        return (int) $hours;
    }

    public function countHoursByUserId(int $userId): int
    {
        $count = $this->findWhere(['user_id' => $userId])->count();

        return (int) $count;
    }
}