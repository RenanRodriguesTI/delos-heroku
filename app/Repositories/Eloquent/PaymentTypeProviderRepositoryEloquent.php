<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\PaymentTypeProviders;
use Delos\Dgp\Repositories\Contracts\PaymentTypeProviderRepository;
use Delos\Dgp\Repositories\Criterias\PaymentTypeProviders\FilterCriteria;
use Illuminate\Database\Eloquent\Builder;

class PaymentTypeProviderRepositoryEloquent extends BaseRepository implements PaymentTypeProviderRepository
{

    protected $fieldSearchable = [
        'name' =>'like'
    ];

    public function boot(){
        parent::boot();
        $this->pushCriteria(FilterCriteria::class);
    }
    public function model()
    {
        return PaymentTypeProviders::class;
    }
}