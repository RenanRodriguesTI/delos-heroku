<?php

namespace Delos\Dgp\Transformers;

use Delos\Dgp\Entities\Request;
use League\Fractal\TransformerAbstract;

/**
 * Class RequestTransformerTransformer
 * @package namespace Delos\Dgp\Transformers;
 */
class RequestTransformer extends TransformerAbstract
{

    /**
     * Transform the \RequestTransformer entity
     * @param \RequestTransformer $model
     *
     * @return array
     */
    public function transform(Request $model)
    {
        if(true === $model->approved) {
            $approved = 'Sim';
        } elseif(false === $model->approved) {
            $approved = 'Não';
        } else {
            $approved = 'Aguardando Aprovação';
        }

        return [
            'id' => (int) $model->id,
            'project' => $model->project->full_description,
            'requester' => $model->requester->name,
            'collaborators' => $model->users->implode('name', ','),
            'created_at' => $model->created_at->format('d/m/Y H:i:s'),
            'approved' => $approved,
            'ticket' => $model->children()->first()->tickets()->count() ? 'Sim' : 'Não',
            'car' => $model->children()->first()->car ? 'Sim' : 'Não',
            'lodging' => $model->children()->first()->lodging ? 'Sim' : 'Não',
            'advance_money' => $model->children()->first()->extraExpenses()->sum('value'),
            'start' => $model->start->format('d/m/Y'),
            'finish' => $model->finish->format('d/m/Y')
        ];
    }
}
