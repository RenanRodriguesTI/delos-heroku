<?php

namespace Delos\Dgp\Http\Middleware;

use Closure;
use Delos\Dgp\Http\Controllers\ResourceNamesTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Authorize
{
    use AuthorizesRequests;
    use ResourceNamesTrait;

    public function handle($request, Closure $next)
    {	
        $this->authorize($this->getAbility());
        return $next($request);
    }
}
