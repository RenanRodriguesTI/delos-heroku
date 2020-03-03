<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 24/08/17
 * Time: 10:31
 */

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Module;
use Delos\Dgp\Presenters\ModulePresenter;
use Delos\Dgp\Repositories\Contracts\ModuleRepository;

class ModuleRepositoryEloquent extends BaseRepository implements ModuleRepository
{
    protected $fieldSearchable = [
        'name' => 'like'
    ];

    public function presenter()
    {
        return ModulePresenter::class;
    }

    public function model()
    {
        return Module::class;
    }
}