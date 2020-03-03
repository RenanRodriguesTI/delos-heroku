<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Role;

class RoleTransformer extends TransformerAbstract
{

    public function transform(Role $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'slug' => $model->slug,
        ];
    }
}
