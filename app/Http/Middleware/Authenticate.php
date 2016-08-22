<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

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
        $notAuth = false;
        if ($guard == 'all') {
            if (Auth::guard('admin')->guest() && Auth::guard('brand')->guest() && Auth::guard('agency')->guest() && Auth::guard('creative')->guest()) {
                $notAuth = true;
            }
        } else if ($guard == 'brand_agency') {
            if (Auth::guard('admin')->guest() && Auth::guard('brand')->guest() && Auth::guard('agency')->guest()) {
                $notAuth = true;
            }
        } else {
            if (Auth::guard($guard)->guest()) {
                $notAuth = true;
            }
        }

        if ($notAuth) {
            $route = route('core_admin_login');
            if ($request->ajax()) {
                //return response('Unauthorized.', 401);
                return new JsonResponse(['path' => $route], 401);
            } else {
                return redirect($route);
            }
        }

		return $next($request);
	}
}
