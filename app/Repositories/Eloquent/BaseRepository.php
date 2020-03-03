<?php

namespace Delos\Dgp\Repositories\Eloquent;

use Delos\Dgp\Repositories\Criterias\MultiTenant\ScopeCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository as BasePrettusRepository;

abstract class BaseRepository extends BasePrettusRepository
{
    protected $skipPresenter = true;

    public function pluck($column, $key = null)
    {
        $this->applyCriteria();
        $this->applyScope();

        return $this->model->pluck($column, $key);
    }

    public function getAllSoftDelete(bool $paginate = true, int $limit = null, array $columns = ['*'])
    {
        $this->applyCriteria();

        $builder = $this->model->onlyTrashed();

        if(true === $paginate) {
            $results = $builder->paginate($limit, $columns);
        } else {
            $results = $builder->get($columns);
        }

        return $this->parserResult($results);
    }

    public function restore($id)
    {
        return $this->model
            ->onlyTrashed()
            ->where('id', $id)
            ->restore();
    }

    public function boot()
    {
        $this->pushCriteria(ScopeCriteria::class);
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getData()
    {
        $request = app('request');

        if($request->input('report') === 'xlsx') {
            $this->skipPresenter(false);
            return $this->all()['data'];
        }

        return $this->paginate();
    }

    public function withTrashed()
    {
        $this->model = in_array('restore', get_class_methods($this->model->getModel())) ? $this->model->withTrashed() : $this->model;
        return $this;
    }
}