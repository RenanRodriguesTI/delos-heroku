<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Place;

class PlaceTransformer extends TransformerAbstract
{

    public function transform(Place $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
        ];
    }
}
