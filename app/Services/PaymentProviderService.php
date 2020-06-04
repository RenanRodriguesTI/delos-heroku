<?php
namespace Delos\Dgp\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use Delos\Dgp\Repositories\Eloquent\PaymentTypeProviderRepositoryEloquent;

class PaymentProviderService extends AbstractService{
    public function repositoryClass(): string{
        return PaymentTypeProviderRepositoryEloquent::class;
    }
}