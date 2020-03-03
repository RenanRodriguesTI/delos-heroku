<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Task;

/**
 * Class TaskTransformer
 * @package namespace Delos\Dgp\Transformers;
 */
class TaskTransformer extends TransformerAbstract
{

    public function transform(Task $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name
        ];
    }
}
