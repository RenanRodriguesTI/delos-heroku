<?php

namespace Delos\Dgp\Transformers;

use League\Fractal\TransformerAbstract;
use Delos\Dgp\Entities\SupplierExpenses;

/**
 * Class SupplierExpensesTransformer
 * @package namespace Delos\Dgp\Transformers;
 */
class SupplierExpensesTransformer extends TransformerAbstract
{

    public function transform(SupplierExpenses $model)
    {
        return [
            'id' => (int) $model->id,
            'provider_id' => $model->provider_id,
            'invoice' => $model->invoice,
            'issue_date' => $model->issue_date,
            'value' => $model->value,
            'payment_type_provider_id' => $model->payment_type_provider_id,
            'description_id' => $model->description_id,
            'note' => $model->note,
            'provider_id' => $model->provider_id,
            'establishment_id' => $model->establishment_id,
            'voucher_type_id' => $model->voucher_type_id,
            'exported' => $model->exported,
            'project_id' => $model->project_id,
            'debit_memo_id' => $model->debit_memo_id,
            'original_name' => $model->original_name,
            's3_name' => $model->s3_name,
        ];
    }
}
