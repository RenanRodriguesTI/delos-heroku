<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\ApprovedNotification;

/**
 * Class ApprovedNotificationTransformer.
 *
 * @package namespace Delos\Dgp\Transformers;
 */
class ApprovedNotificationTransformer extends TransformerAbstract
{
    /**
     * Transform the ApprovedNotification entity.
     *
     * @param \Delos\Dgp\Entities\ApprovedNotification $model
     *
     * @return array
     */
    public function transform(ApprovedNotification $model)
    {
        return [
            'id'         => (int) $model->id,
            'leader_id' =>(int) $model->leader_id,
            'leader' => $model->leader->name,
            'user_id' =>$model->user->id,
            'user'=>$model->user->name,
            'title' => $model->title,
            'subtitle' => $model->subtitle,
            'ready' => $model->ready,
            'approved' =>$model->approved,
            'reason' =>$model->reason,
            'value' => 
                $model->typeNotify->name == "Despesa" ?
                    number_format($model->value,2,',','.'):
                    (int)$model->value,
            'created_at' => $model->created_at->format('d/m/Y'),
            'updated_at' => $model->updated_at->format('d/m/Y'),
            'deleted_at' =>$model->deleted_at ? $model->deleted_at->format('d/m/Y') : null,
            'type_notify_id'=>$model->type_notify_id,
            'type_notify'=>$model->typeNotify
        ];
    }
}
