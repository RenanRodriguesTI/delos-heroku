<?php

namespace Delos\Dgp\Observers;

use Delos\Dgp\Entities\Permission;
use Delos\Dgp\Entities\User;
use Delos\Dgp\Repositories\Contracts\PermissionRepository;
use Delos\Dgp\Repositories\Contracts\UserRepository;
use Illuminate\Foundation\Application;

class UserObserver
{

    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function deleting(User $user)
    {
        $user->missingActivities()->delete();

        $user->allocations()->delete();
    }

    public function restoring(User $user)
    {
        $user->missingActivities()->onlyTrashed()->restore();
    }
}