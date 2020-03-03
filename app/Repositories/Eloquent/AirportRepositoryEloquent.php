<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Airport;
use Delos\Dgp\Repositories\Contracts\AirportRepository;
use Delos\Dgp\Presenters\AirportPresenter;

class AirportRepositoryEloquent extends BaseRepository implements AirportRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'initials',
        'state.name'
    ];

    public function model()
    {
        return Airport::class;
    }

    public function presenter()
    {
        return AirportPresenter::class;
    }

    public function getPairsByStateId(int $stateId) : array
    {
        $collection = $this->orderBy('name')
            ->findByField('state_id', $stateId, ['id', 'name', 'initials']);

        $values = $collection->map(function($value) {
            return "$value->name - $value->initials";
        });

        $keys = $collection->map(function ($value) {
            return $value->id;
        });

        $result = $keys->combine($values)->all();

        return $result;
    }
}