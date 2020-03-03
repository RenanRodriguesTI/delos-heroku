<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Audit;

class AuditTransformer extends TransformerAbstract
{
    public function transform(Audit $model)
    {
        return [
            'id'            => (int) $model->id,
            'user_name'     => $model->user()->withTrashed()->first()->name,
            'group_name'    => $model->groupCompany()->first()->name,
            'event'         => $model->event,
            'auditable_id'  => $model->auditable_id,
            'auditable_type'=> $model->auditable_type,
            'old_values'    => json_encode($model->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'new_values'    => json_encode($model->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'url'           => $model->url,
            'ip_address'    => $model->ip_address,
            'user_agent'    => $model->user_agent,
            'created_at'    => $model->created_at->format('d/m/Y')
        ];
    }
}
