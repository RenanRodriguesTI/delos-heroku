<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Activity;

class ActivityTransformer extends TransformerAbstract
{

    public function transform(Activity $model)
    {
        $status = $model->approved ?
            trans('entries.status.approved')
            :
            trans('entries.status.waiting-for-approval');

        return [
            'id' => (int) $model->id,
            'collaborator' => $model->user()->withTrashed()->first()->name,
            'project' => $model->project->full_description,
            'date' => $model->date->format('d/m/Y'),
            'hours' => $model->hours,
            'task' => $model->task->name,
            'place' => $model->place->name ?? null,
            'note' => $model->note,
            'created_at' => is_null($model->created_at) ?: $model->created_at->format('d/m/Y') ?? null,
            'status' => $status
        ];
    }
}
