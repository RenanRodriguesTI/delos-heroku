<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Carbon\Carbon;
use Delos\Dgp\Entities\Audit;
use Delos\Dgp\Presenters\AuditPresenter;
use Delos\Dgp\Repositories\Contracts\AuditRepository;
use Delos\Dgp\Repositories\Contracts\HolidayRepository;
use Delos\Dgp\Repositories\Contracts\RequestRepository;
use Delos\Dgp\Repositories\Criterias\Audit\ScopeCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Criteria\RequestCriteria;

class AuditRepositoryEloquent extends BaseRepository implements AuditRepository
{
    protected $fieldSearchable = [
        'id'                => 'like',
        'user.name'         => 'like',
        'groupCompany.name' => 'like',
        'event'             => 'like',
        'auditable_id'      => 'like',
        'auditable_type'    => 'like',
        'old_values'        => 'like',
        'new_values'        => 'like',
        'url'               => 'like',
        'ip_address'        => 'like',
        'user_agent'        => 'like',
        'created_at'        => 'like'
    ];

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        
        parent::boot();
    }

    public function model()
    {
        return Audit::class;
    }

    public function presenter()
    {
        return AuditPresenter::class;
    }

    public function all($columns = array())
    {
        $result = $this->skipPresenter(true)
                        ->popCriteria(\Delos\Dgp\Repositories\Criterias\MultiTenant\ScopeCriteria::class)
                        ->pushCriteria(\Delos\Dgp\Repositories\Criterias\GroupCompany\GroupCompanyCriteria::class)
                        ->with(['user', 'groupCompany']);

        return $result;
    }
}