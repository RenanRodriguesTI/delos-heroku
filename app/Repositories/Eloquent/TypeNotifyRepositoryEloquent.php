<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delos\Dgp\Repositories\Contracts\TypeNotifyRepository;
use Delos\Dgp\Entities\TypeNotify;
use Delos\Dgp\Validators\TypeNotifyValidator;

/**
 * Class TypeNotifyRepositoryEloquent.
 *
 * @package namespace Delos\Dgp\Repositories;
 */
class TypeNotifyRepositoryEloquent extends BaseRepository implements TypeNotifyRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TypeNotify::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
