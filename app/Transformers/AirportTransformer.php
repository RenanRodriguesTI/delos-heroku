<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Airport;

class AirportTransformer extends TransformerAbstract
{

    public function transform(Airport $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'state' => $model->state->name,
            'initials' => $model->initials
        ];
    }
}
