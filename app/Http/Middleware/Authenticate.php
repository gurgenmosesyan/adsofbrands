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
		if (Auth::guard($guard)->guest()) {
            $route = $guard == 'admin' ? route('core_admin_login') : route('user_login', cLng('code'));
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
