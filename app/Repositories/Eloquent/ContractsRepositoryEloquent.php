<?php

namespace Delos\Dgp\Repositories\Contracts;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delos\Dgp\Repositories\Contracts\ContractsRepository;
use Delos\Dgp\Entities\Contracts\Contracts;
use Delos\Dgp\Validators\Contracts\ContractsValidator;

/**
 * Class ContractsRepositoryEloquent.
 *
 * @package namespace Delos\Dgp\Repositories\Contracts;
 */
class ContractsRepositoryEloquent extends BaseRepository implements ContractsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */

    public function __construct()
    {
        
    }
    public function model()
    {
        return Contracts::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
