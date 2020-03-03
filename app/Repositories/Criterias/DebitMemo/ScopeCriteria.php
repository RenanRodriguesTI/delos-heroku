<?php

namespace Delos\Dgp\Repositories\Criterias\DebitMemo;

use Delos\Dgp\Repositories\Contracts\PermissionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ScopeCriteria
 * @package Delos\Dgp\Repositories\Criterias\DebitMemo
 */
class ScopeCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $authenticatedUser;

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if ($this->getAuthenticatedUser()->role->name == 'Client') {
            $model->where(function ($query) {
                $query->whereHas('expenses.project', function ($query) {
                    $query->Where('client_id', $this->getAuthenticatedUser()->id);
                });
            });
        }

        return $model;
    }

    /**
     * @return mixed
     */
    private function getAuthenticatedUser()
    {
        if (is_null($this->authenticatedUser)) {
            $this->authenticatedUser = app('auth')->getUser();
        }

        return $this->authenticatedUser;
    }
}