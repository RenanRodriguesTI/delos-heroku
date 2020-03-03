<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\PaymentType;
use Delos\Dgp\Repositories\Contracts\PaymentTypeRepository;

class PaymentTypeRepositoryEloquent extends BaseRepository implements PaymentTypeRepository
{
    public function model()
    {
        return PaymentType::class;
    }
}