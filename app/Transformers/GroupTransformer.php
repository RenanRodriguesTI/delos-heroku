<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Group;

class GroupTransformer extends TransformerAbstract
{

    public function transform(Group $model)
    {
        return [
            'id' => $model->id,
            'cod' => $model->cod,
            'name' => $model->name,
            'clients' => $model->clients->implode('name', ', ')
        ];
    }
}
