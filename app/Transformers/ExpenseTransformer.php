<?php

    namespace Delos\Dgp\Transformers;

    use League\Fractal\TransformerAbstract;
    use Delos\Dgp\Entities\Expense;

    class ExpenseTransformer extends TransformerAbstract
    {

        public function transform(Expense $model)
        {
            return [
                'id'           => (int)$model->id,
                'project'      => $model->project->full_description,
                'request'      => $model->request_id ? $model->request_id : $model->project->compiled_cod,
                'invoice'      => $model->invoice,
                'issue_date'   => $model->issue_date->format('d/m/Y'),
                'value'        => $model->value,
                'payment_type' => $model->paymentType->name,
                'description'  => $model->description,
                'note'         => $model->note,
                'collaborator' => $model->user->name,
                'invoice_file' => $model->url_file,
                'exported'     => trans("entries.status.{$model->status}")
            ];
        }
    }
