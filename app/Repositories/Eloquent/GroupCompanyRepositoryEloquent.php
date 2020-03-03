<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 20/07/17
 * Time: 16:02
 */

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\GroupCompany;
use Delos\Dgp\Repositories\Contracts\GroupCompanyRepository;

class GroupCompanyRepositoryEloquent extends BaseRepository implements GroupCompanyRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GroupCompany::class;
    }
}