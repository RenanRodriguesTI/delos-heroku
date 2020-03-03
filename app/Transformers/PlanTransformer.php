<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 22/08/17
 * Time: 15:13
 */

namespace Delos\Dgp\Transformers;

use Delos\Dgp\Entities\Plan;
use League\Fractal\TransformerAbstract;

class PlanTransformer extends TransformerAbstract
{
    public function transform(Plan $model) {
        return [
            'name' => $model->name,
            'billing_type' => $model->billing_type,
            'periodicity' => $model->periodicity,
            'value' => $model->value,
            'trial_period' => $model->trial_period,
            'max_users' => $model->max_users,
        ];
    }
}