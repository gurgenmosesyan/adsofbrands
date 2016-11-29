<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Core\Exceptions\AccessDeniedException;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->guest()) {
            return $next($request);
        }

        $admin = Auth::guard('admin')->user();
        if ($admin->isSuperAdmin()) {
            return $next($request);
        }

        $action = $request->route()->getAction();

        if (isset($action['permission']) && !isset($admin->permissions[$action['permission']])) {
            throw new AccessDeniedException(403, 'Permission denied');
        }

        return $next($request);
    }
}