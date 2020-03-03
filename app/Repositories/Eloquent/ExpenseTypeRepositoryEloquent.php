<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\ExpenseType;
use Delos\Dgp\Repositories\Contracts\ExpenseTypeRepository;
use Illuminate\Container\Container as Application;

class ExpenseTypeRepositoryEloquent extends BaseRepository implements ExpenseTypeRepository
{
    private $paymentTypeRepository;

    protected $fieldSearchable = [
      'description' => 'LIKE',
      'cod' => 'LIKE'
    ];

    public function __construct(Application $app, PaymentTypeRepositoryEloquent $paymentTypeRepository)
    {
        parent::__construct($app);
        $this->paymentTypeRepository = $paymentTypeRepository;
    }

    public function model()
    {
        return ExpenseType::class;
    }

    public function getDataPairs(int $id) : iterable
    {
        $data = $this->paymentTypeRepository->find($id)->expenseTypes->pluck('description', 'id');

        return $data->all();
    }

    public function attachPaymentTypes(int $expenseTypeId, $paymentTypesIds): void
    {
        $this->find($expenseTypeId)
            ->paymentTypes()
            ->attach($paymentTypesIds);
    }

    public function syncPaymentTypes(int $expenseTypeId, $paymentTypesIds): void
    {
        $this->find($expenseTypeId)
            ->paymentTypes()
            ->sync($paymentTypesIds);
    }
}