<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Holiday;

/**
 * Class HolidayTransformer.
 *
 * @package namespace Delos\Dgp\Transformers;
 */
class HolidayTransformer extends TransformerAbstract
{
    /**
     * Transform the Holiday entity.
     *
     * @param \Delos\Dgp\Entities\Holiday $model
     *
     * @return array
     */
    public function transform(Holiday $model)
    {
        return [
            'date' => $model->date->format('d/m/Y'),
        ];
    }
}
