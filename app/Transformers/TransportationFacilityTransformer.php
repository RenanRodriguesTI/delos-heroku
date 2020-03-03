<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\TransportationFacilities;

class TransportationFacilityTransformer extends TransformerAbstract
{

    public function transform(TransportationFacilities $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name
        ];
    }
}
