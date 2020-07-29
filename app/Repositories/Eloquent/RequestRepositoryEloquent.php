<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Carbon\Carbon;
use Delos\Dgp\Entities\Request;
use Delos\Dgp\Presenters\RequestPresenter;
use Delos\Dgp\Repositories\Contracts\RequestRepository;
use Delos\Dgp\Repositories\Criterias\Common\FilterCriteria;
use Delos\Dgp\Repositories\Criterias\RequestCriteria;
use Delos\Dgp\Repositories\Criterias\Request\ScopeCriteria;

class RequestRepositoryEloquent extends BaseRepository implements RequestRepository
{

    public function boot()
    {
        $this->pushCriteria(new RequestCriteria());
        $this->pushCriteria(new ScopeCriteria());
        $this->pushCriteria(new FilterCriteria());
        parent::boot();
    }

    public function model()
    {
        return Request::class;
    }

    public function presenter()
    {
        return RequestPresenter::class;
    }

    public function getRequestsByProjectId(int $projectId, bool $paginate = true, int $limit = null, array $columns = ['*'])
    {
        $model = $this->scopeQuery(function ($builder) use($projectId) {
            return $builder->where('project_id', $projectId);
        });

        if($paginate) {
            return $model->paginate($limit, $columns);
        }

        return $model->all($columns);
    }

    public function getApprovedRequestsPairsByProjectId(int $projectId) : iterable
    {
        $model = $this->scopeQuery(function ($builder) use($projectId) {
            $builder = $builder->where('project_id', $projectId)
                ->where('approved', true);

            return $builder;
        });

        $requests = $model->all();

        $keyed = $requests->keyBy('id');
        $result = $keyed->map(function($value) {
            $value = ucfirst(trans('entries.request')) . ": $value->id";
            return $value;
        });

        return $result->all();
    }

    public function getPairsByDate(Carbon $date) : iterable
    {
        $this->applyCriteria();
        $this->applyScope();

        $requests = $this->model->with('project')
            ->whereRaw("'{$date->toDateString()}' BETWEEN start and finish")
            ->get();

        $transformed = $requests->transform(function ($request) {

            return [
                'id' => $request->id,
                'description' => "Nº: $request->id - De: {$request->start->format('d/m/Y')} - Até: {$request->finish->format('d/m/Y')} * Descrição do projeto: {$request->project->description}"
            ];
        });

        return $transformed->pluck('description', 'id');
    }
}