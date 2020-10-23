<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Delos\Dgp\Repositories\Contracts\CurseRepository;
use Delos\Dgp\Entities\Curse;
use Prettus\Repository\Criteria\RequestCriteria;
use Delos\Dgp\Repositories\Criterias\Curse\CurseCriteria;
use Delos\Dgp\Presenters\CursePresenter;

/**
 * Class CurseRepositoryEloquent.
 *
 * @package namespace Delos\Dgp\Repositories;
 */
class CurseRepositoryEloquent extends BaseRepository implements CurseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */

    protected $skipPresenter = true;

    protected $fieldSearchable =[
        'name'=>'like'
    ];
    public function model()
    {
        return Curse::class;
    }

    public function presenter(){
        return CursePresenter::class;
    }


    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(CurseCriteria::class);
    }
    
}
