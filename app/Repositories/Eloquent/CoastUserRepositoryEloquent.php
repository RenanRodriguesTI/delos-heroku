<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Prettus\Repository\Criteria\RequestCriteria;
use Delos\Dgp\Repositories\Contracts\CoastUserRepository;
use Delos\Dgp\Entities\CoastUser;
use Delos\Dgp\Validators\CoastUserValidator;

/**
 * Class CoastUserRepositoryEloquent.
 *
 * @package namespace Delos\Dgp\Repositories;
 */
class CoastUserRepositoryEloquent extends BaseRepository implements CoastUserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CoastUser::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CoastUserValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
