<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Contracts\StateRepository;

class AirportsController extends AbstractController
{
    protected function getVariablesForPersistenceView(): array
    {
        return [
            'states' => app(StateRepository::class)->pluck('name', 'id')
        ];
    }
}
