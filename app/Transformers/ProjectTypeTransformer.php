<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\ProjectType;

class ProjectTypeTransformer extends TransformerAbstract
{

    public function transform(ProjectType $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name
        ];
    }
}