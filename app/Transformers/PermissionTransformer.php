<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Permission;

class PermissionTransformer extends TransformerAbstract
{

    public function transform(Permission $model)
    {
        return [
            'id' => (int) $model->id,
            'slug' => $model->slug,
            'name' => $model->name
        ];
    }
}
