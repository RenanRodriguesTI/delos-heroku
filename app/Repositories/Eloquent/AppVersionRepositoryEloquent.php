<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\AppVersion;

use Delos\Dgp\Repositories\Contracts\AppVersionRepository;

class AppVersionRepositoryEloquent extends BaseRepository implements AppVersionRepository{
    protected $fieldSearchable = [
        'version' => 'like'
    ];

    public function model(){
        return AppVersion::class;
    }
}