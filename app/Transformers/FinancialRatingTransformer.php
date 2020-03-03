<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\FinancialRating;

class FinancialRatingTransformer extends TransformerAbstract
{

    public function transform(FinancialRating $model)
    {
        return [
            'id' => (int) $model->id,
            'cod' => $model->cod,
            'description' => $model->description,
        ];
    }
}
