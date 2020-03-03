<?php

namespace Delos\Dgp\Repositories\Contracts;

interface ExpenseTypeRepository extends RepositoryInterface
{
    public function getDataPairs(int $id) : iterable;

    /**
     * @param $paymentTypesIds array | integer
     */
    public function attachPaymentTypes(int $expenseTypeId, $paymentTypesIds) : void;

    /**
     * @param $paymentTypesIds array | integer
     */
    public function syncPaymentTypes(int $expenseTypeId, $paymentTypesIds) : void;
}