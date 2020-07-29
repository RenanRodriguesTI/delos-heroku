<?php

namespace Delos\Dgp\Repositories\Eloquent;
use Delos\Dgp\Repositories\Contracts\OfficeRepository;
use Delos\Dgp\Entities\Office;
use Illuminate\Database\Eloquent\Builder;
use Delos\Dgp\Repositories\Criterias\Office\FilterCriteria;

class OfficeRepositoryEloquent extends BaseRepository implements OfficeRepository{

    protected $fieldSearchable =[
        'name' => 'like'
    ];

    public function boot(){
        $this->pushCriteria(FilterCriteria::class);
        parent::boot();
    }

    public function model(){
        return Office::class;
    }
}