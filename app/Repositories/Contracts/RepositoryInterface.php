<?php

namespace Delos\Dgp\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

interface RepositoryInterface extends PrettusRepositoryInterface
{
    public function pluck($column, $key = null);
}