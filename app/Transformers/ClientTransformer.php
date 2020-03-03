<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Client;

class ClientTransformer extends TransformerAbstract
{

    public function transform(Client $model)
    {
        return [
            'id' => (int) $model->id,
            'groupCod' => $model->group->cod,
            'groupName' => $model->group->name,
            'cod' => $model->cod,
            'name' => $model->name
        ];
    }
}
