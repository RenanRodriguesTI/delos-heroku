<?php

namespace Delos\Dgp\Transformers;

use Delos\Dgp\Entities\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $model)
    {
        $data = [
            'id' => $model->id,
            'name' => $model->name,
            'email' => $model->email,
            'admission' => $model->admission->format('d/m/Y'),
            'role' => $model->role->name,
            'overtime' => $model->overtime,
            'supplier_number' => $model->supplier_number,
            'account_number' => $model->account_number,
            'company' => $model->company->name ?? '',
            'is_partner_business' => !$model->is_partner_business ? 'NÃO' : 'SIM'
        ];

        if(!is_null($model->deleted_at)) {
            $data['deleted_at'] = $model->deleted_at->format('d/m/Y H:i');
        }

        return $data;
    }
}
