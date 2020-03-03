<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\StateRepository;
use Illuminate\Http\Request;

class CitiesController extends AbstractController
{
    protected function getVariablesForPersistenceView(): array
    {
        return [
            'states' => app(StateRepository::class)->pluck('name', 'id')
        ];
    }

    public function byState($stateId, Request $request)
    {
        $cities = $this->repository
            ->findByField('state_id', $stateId, ['name', 'id'])
            ->pluck('name', 'id');

        if($request->wantsJson()) {
            return $this->response->json($cities);
        }

        return $cities;
    }
}
