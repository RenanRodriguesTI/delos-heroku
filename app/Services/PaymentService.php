<?php
namespace Delos\Dgp\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use Delos\Dgp\Repositories\Eloquent\PaymentTypeRepositoryEloquent;

class PaymentService extends AbstractService{
    public function repositoryClass(): string{
        return PaymentTypeRepositoryEloquent::class;
    }
}