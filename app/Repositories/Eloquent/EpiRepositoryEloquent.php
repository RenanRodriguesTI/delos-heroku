<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Repositories\Contracts\EpiRepository;
use Delos\Dgp\Entities\Epi;
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
class EpiRepositoryEloquent extends BaseRepository implements EpiRepository
{

    protected $fieldSearchable = [
        'name' => 'like'
    ];

    protected $skipPresenter = true;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Epi::class;
    }

    public function presenter()
    {
        return EpiPresenter::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        // $this->pushCriteria(EpiCriteria::class);
    }

    public function getEpiUser($id){
        $epis = $this->model->all();
        $epis->map(function($model) use ($id){
            $model->epi_user = EpiUser::where('user_id',$id)->where('epi_id',$model->id)->get()->first();
            if($model->epi_user){
                $model->epi_user->file_url =  $model->epi_user->file_url ?  $model->epi_user->file_url: '';
                $model->epi_user->expired= $model->epi_user->expired;
            }
            return $model;
        });
        return $epis;
    }
}
