<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\City;

class CityTransformer extends TransformerAbstract
{

    public function transform(City $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'state' => $model->state->name,
        ];
    }
}
