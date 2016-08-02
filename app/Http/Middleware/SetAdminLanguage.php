<?php

namespace App\Http\Middleware;

use App\Core\Language\Manager as LngManager;
use Closure;
use Auth;

class SetAdminLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin != null && !empty($admin->lng_id)) {
            $lngManager = new LngManager();
            $lngManager->setCurrentLanguageById($admin->lng_id);
        }

        return $next($request);
    }
}
