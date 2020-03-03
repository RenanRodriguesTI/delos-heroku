<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 15/02/17
 * Time: 15:08
 */

namespace Delos\Dgp\Transformers;

use Delos\Dgp\Entities\DebitMemo;
use League\Fractal\TransformerAbstract;

class DebitMemoTransformer extends TransformerAbstract
{
    public function transform(DebitMemo $model)
    {
        return [
            'id' => (int) $model->id,
            'number_debit_memo' => $model->code,
            'project' => $model->expenses->first()->project->full_description,
            'status' => trans('debitMemos.index.status.' . $model->status),
            'value_total' => 'R$ ' . $model->value_total
        ];
    }
}