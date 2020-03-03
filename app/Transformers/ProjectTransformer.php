<?php

namespace Delos\Dgp\Transformers;

use Illuminate\Support\Facades\Gate;
use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\Project;

class ProjectTransformer extends TransformerAbstract
{

    public function transform(Project $model)
    {
        $coOwner = $model->coOwner !== null ? $model->coOwner->name : null;
        $members = $model->members->implode('name', ', ');

        $data = [
            'id' => (int) $model->id,
            'compiled_cod' => $model->compiled_cod,
            'description' => $model->description,
            'owner' => $model->owner->name,
            'co_owner' => $coOwner,
            'members' => $members,
            'start' => $model->start->format('d/m/Y'),
            'finish' => $model->finish->format('d/m/Y'),
            'last_activity' => $model->last_activity ? $model->last_activity->format('d/m/Y H:i') : null,
            'budget' => $model->budget,
            'spent' => $model->getSpentHours(),
            'percentage' => number_format($model->getHoursPercentage(), 2, ',', '.'),
            'proposal_number' => $model->proposal_number,
            'proposal' => Gate::allows('see-proposal-value') ? number_format($model->proposal_value, 2, ',', '.') : null,
            'company' => $model->company->name ?? null
        ];

        if(!is_null($model->deleted_at)) {
            $data['deleted_at'] = $model->deleted_at->format('d/m/Y H:i');
        }

        
        return $data;
    }
}
