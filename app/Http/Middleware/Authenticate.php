<?php

namespace Delos\Dgp\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                $path = $request->getPathInfo();
                if($path !== '/auth/login' && $path !== '/') {
                    return redirect()->guest("/auth/login?next-uri={$request->getUri()}");
                }

                return redirect()->guest('/auth/login');
            }
        }

        return $next($request);
    }
}
