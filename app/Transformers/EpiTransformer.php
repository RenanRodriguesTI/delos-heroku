<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Epi;

/**
 * Class EpiTransformer.
 *
 * @package namespace Delos\Dgp\Transformers;
 */
class EpiTransformer extends TransformerAbstract
{
    /**
     * Transform the Epi entity.
     *
     * @param \Delos\Dgp\Entities\Epi $model
     *
     * @return array
     */
    public function transform(Epi $model)
    {
        return [
            'id'         => (int) $model->id,
            'name' => $model->name,
            'epi_user' => $model->epi_user ?? null,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
