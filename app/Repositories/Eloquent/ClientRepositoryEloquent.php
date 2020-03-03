<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Entities\Client;
use Delos\Dgp\Entities\Project;
use Delos\Dgp\Repositories\Contracts\ClientRepository;
use Delos\Dgp\Presenters\ClientPresenter;
use Illuminate\Database\Eloquent\Builder;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
    protected $fieldSearchable = [
        'cod',
        'name' => 'like',
        'group.cod',
        'group.name' => 'like'
    ];

    public function model()
    {
        return Client::class;
    }

    public function presenter()
    {
        return ClientPresenter::class;
    }

    public function countByProjectId(int $projectId): int
    {
        $model = $this->model->whereHas('projects', function($builder) use($projectId) {
            $builder->where('id', $projectId);
        });

        return $model->count();
    }
}