<?php

namespace Delos\Dgp\Http\Middleware;

use Closure;

class ForceSSL
{
    /**
     * Redirect to https.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( $request->header('x-forwarded-proto') <> 'https' && env('APP_ENV') !== 'local' ){
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }

}