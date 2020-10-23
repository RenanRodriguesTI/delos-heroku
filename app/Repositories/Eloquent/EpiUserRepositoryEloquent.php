<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Repositories\Contracts\EpiRepository;
use Delos\Dgp\Entities\EpiUser;
// use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delos\Dgp\Repositories\Criterias\Epi\EpiCriteria;
use Delos\Dgp\Presenters\EpiPresenter;

/**
 * Class EpiRepositoryEloquent.
 *
 * @package namespace Delos\Dgp\Repositories;
 */
class EpiUserRepositoryEloquent extends BaseRepository implements EpiRepository
{
    
    protected $fieldSearchable =[
        'ca'=>'like',
        'epi.name'=>'like'
    ];

    protected $skipPresenter= true;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EpiUser::class;
    }

    public function presenter()
    {
        return EpiPresenter::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    
    
}
