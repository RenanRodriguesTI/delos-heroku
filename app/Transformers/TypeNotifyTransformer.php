<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\TypeNotify;

/**
 * Class TypeNotifyTransformer.
 *
 * @package namespace Delos\Dgp\Transformers;
 */
class TypeNotifyTransformer extends TransformerAbstract
{
    /**
     * Transform the TypeNotify entity.
     *
     * @param \Delos\Dgp\Entities\TypeNotify $model
     *
     * @return array
     */
    public function transform(TypeNotify $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
