<?php
/**
 * Created by PhpStorm.
 * User: allan
 * Date: 25/08/17
 * Time: 16:54
 */

namespace Delos\Dgp\Http\Middleware;

use Closure;
use Delos\Dgp\Http\Controllers\ResourceNamesTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ModulesPermissions
{
    use AuthorizesRequests, ResourceNamesTrait;

    public function handle($request, Closure $next, $guard = null)
    {
        if (!$this->groupAuthorize() && !Auth::guest()) {
            throw new AuthorizationException();
        }

        return $next($request);
    }

    public function groupAuthorize($ability = null) : bool
    {
        $permissions = $this->getPermissions();

        return $this->authorize($permissions, $ability ?? $this->getAbility());
    }

    private function getPermissions(): array
    {
        $modules = \Auth::user()->groupCompany->plan->modules;
        $permissions = [];

        foreach ($modules as $module) {
            foreach ($module->permissions as $permission) {
                array_push($permissions, $permission->slug);
            }
        }
        return $permissions;
    }

    private function authorize($permissions, $ability): bool
    {
        if (!in_array($ability, $permissions) && \Auth::user()->role_id !== 5) {
            return false;
        }

        return true;
    }
}