<?php

namespace Delos\Dgp\Providers;

use Illuminate\Support\ServiceProvider as SP;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends SP
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        /*
         * Authenticate the user's personal channel...
         */
        Broadcast::channel('App.User.{userId}', function ($user, $userId) {
            return (int) $user->id === (int) $userId;
        });
    }
}
