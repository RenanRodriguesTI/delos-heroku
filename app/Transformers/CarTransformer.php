<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Car;

/**
 * Class CarTransformer
 * @package namespace Delos\Dgp\Transformers;
 */
class CarTransformer extends TransformerAbstract
{

    public function transform(Car $model)
    {
        return [
            'car_type' => $model->carType->name,
            'withdrawal_date' => $model->withdrawal_date->format('d/m/Y H:i'),
            'return_date' => $model->return_date->format('d/m/Y H:i'),
            'withdrawal_place' => $model->withdrawal_place,
            'return_place' => $model->return_place,
            'first_driver' => $model->firstDriver->name,
            'second_driver' => $model->secondDriver->name ?? null
        ];
    }
}
