<?php

namespace Delos\Dgp\Http\Controllers;

use Delos\Dgp\Repositories\Eloquent\PaymentTypeRepositoryEloquent;
use Prettus\Validator\Exceptions\ValidatorException;

class ExpenseTypesController extends AbstractController
{
    protected function getVariablesForPersistenceView(): array
    {
        return [
            'paymentTypes' => app(PaymentTypeRepositoryEloquent::class)->pluck('name', 'id')
        ];
    }

    public function store()
    {
        try {
            $expense = $this->service->create($this->request->all());

            $paymentTypesIds = $this->request->input('payment_type_id');
            $this->repository->attachPaymentTypes($expense->id, $paymentTypesIds);

            return $this->response
                ->redirectTo($this->getInitialUrlIndex())
                ->with('success', $this->getMessage('created'));

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()
                ->withErrors($e->getMessageBag())
                ->withInput();
        }

    }

    public function update(int $id)
    {

        try {
            $this->service->update($this->request->all(), $id);

            $paymentTypesIds = $this->request->input('payment_type_id');

            if (!empty($paymentTypesIds) && is_array($paymentTypesIds)) {
                $this->repository->syncPaymentTypes($id, $paymentTypesIds);
            }

            return $this->response
                ->redirectTo($this->getInitialUrlIndex())
                ->with('success', $this->getMessage('edited'));

        } catch (ValidatorException $e) {
            return $this->redirector
                ->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    public function getPairsDescriptions(int $id)
    {
        return $this->response->json(['data' => $this->repository->getDataPairs($id), 200]);
    }
}