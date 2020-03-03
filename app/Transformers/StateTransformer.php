<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\State;

class StateTransformer extends TransformerAbstract
{

    public function transform(State $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
        ];
    }
}
