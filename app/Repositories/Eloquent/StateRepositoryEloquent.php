<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\State;
use Delos\Dgp\Repositories\Contracts\StateRepository;
use Delos\Dgp\Presenters\StatePresenter;

class StateRepositoryEloquent extends BaseRepository implements StateRepository
{

    protected $fieldSearchable = [
        'name' => 'like'
    ];

    public function model()
    {
        return State::class;
    }

    public function presenter()
    {
        return StatePresenter::class;
    }
}