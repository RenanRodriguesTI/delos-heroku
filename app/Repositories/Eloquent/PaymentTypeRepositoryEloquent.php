<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\PaymentType;
use Delos\Dgp\Repositories\Contracts\PaymentTypeRepository;
use Delos\Dgp\Repositories\Criterias\PaymentType\FilterCriteria;

class PaymentTypeRepositoryEloquent extends BaseRepository implements PaymentTypeRepository
{
    protected $fieldSearchable =[
        'name' =>'like'
    ];

    public function boot(){
        parent::boot();
        $this->pushCriteria(FilterCriteria::class);
    }

    public function model()
    {
        return PaymentType::class;
    }
}