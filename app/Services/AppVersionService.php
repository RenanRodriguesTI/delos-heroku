<?php

namespace Delos\Dgp\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use Delos\Dgp\Repositories\Eloquent\AppVersionRepositoryEloquent;

class AppVersionService extends AbstractService{
    public function repositoryClass(): string{
        return AppVersionRepositoryEloquent::class;
    }

}