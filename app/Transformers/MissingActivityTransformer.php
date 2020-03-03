<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\MissingActivity;

class MissingActivityTransformer extends TransformerAbstract
{

    public function transform(MissingActivity $model)
    {

        return [
            'id' => (int) $model->id,
            'collaborator' => $model->user->name,
            'email' => $model->user->email,
            'role' => $model->user->role->name,
            'date' => $model->date->format('d/m/Y'),
            'hours' => $model->hours,
        ];
    }
}
