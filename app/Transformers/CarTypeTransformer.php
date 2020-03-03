<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\CarType;

class CarTypeTransformer extends TransformerAbstract
{

    public function transform(CarType $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
        ];
    }
}
