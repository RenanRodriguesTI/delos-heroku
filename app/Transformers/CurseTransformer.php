<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Curse;

/**
 * Class CurseTransformer.
 *
 * @package namespace Delos\Dgp\Transformers;
 */
class CurseTransformer extends TransformerAbstract
{
    /**
     * Transform the Curse entity.
     *
     * @param \Delos\Dgp\Entities\Curse $model
     *
     * @return array
     */
    public function transform(Curse $model)
    {
        return [
            'id'         => (int) $model->id,
            'name' => $model->name,
            'end_date' =>$model->end_date ?$model->end_date->format('d/m/Y'):null,
            'renewal_date'=> $model->renewal ?$model->renewal->format('d/m/Y'):null,
            'filename' => $model->filename,
            'file_s3' =>$model->file_s3,
            'user_id' =>$model->user_id,
            'file_url' =>$model->file_s3 ? $model->file_url :"",
            'expired' => $model->expired,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
