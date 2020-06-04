<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\AppVersion;

use Delos\Dgp\Repositories\Contracts\AppVersionApiRepository;
use Delos\Dgp\Repositories\Eloquent\BaseApiRepository;

class AppVersionApiRepositoryEloquent extends BaseApiRepository implements AppVersionApiRepository{
    protected $fieldSearchable = [
        'version' => 'like'
    ];

    public function model(){
        return AppVersion::class;
    }
}