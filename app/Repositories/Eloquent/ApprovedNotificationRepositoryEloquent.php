<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delos\Dgp\Entities\ApprovedNotification;
use Delos\Dgp\Validators\ApprovedNotificationValidator;
use Delos\Dgp\Repositories\Contracts\ApprovedNotificationRepository;
use Delos\Dgp\Presenters\ApprovedNotificationPresenter;
/**
 * Class ApprovedNotificationRepositoryEloquent.
 *
 * @package namespace Delos\Dgp\Repositories;
 */
class ApprovedNotificationRepositoryEloquent extends BaseRepository implements ApprovedNotificationRepository
{

    protected $skipPresenter = true;
    protected $fieldSearchable =[
        'title'=>'like',
        'subtitle'=>'like',
        'user.name' =>'like'
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ApprovedNotification::class;
    }

    public function presenter(){
        return ApprovedNotificationPresenter::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ApprovedNotificationValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
