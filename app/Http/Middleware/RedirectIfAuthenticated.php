<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
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
        if ($guard == 'all') {
            if (Auth::guard('admin')->check()) {
                $admin = Auth::guard('admin')->user();
                if (empty($admin->homepage)) {
                    $permissions = $admin->permissions;
                    $url = empty($permissions) ? 'brand' : key($permissions);
                } else {
                    $url = $admin->homepage;
                }
                $url = url('admpanel/'.ltrim($url, '/'));
                return redirect($url);
            } else if (Auth::guard('brand')->check()) {
                $user = Auth::guard('brand')->user();
                return redirect()->route('admin_brand_edit', $user->id);
            } else if (Auth::guard('agency')->check()) {
                $user = Auth::guard('agency')->user();
                return redirect()->route('admin_agency_edit', $user->id);
            } else if (Auth::guard('creative')->check()) {
                $user = Auth::guard('creative')->user();
                return redirect()->route('admin_creative_edit', $user->id);
            }
        } else {
            if (Auth::guard($guard)->check()) {
                return redirect()->route('admin_brand_table');
            }
        }

        return $next($request);
	}
}
