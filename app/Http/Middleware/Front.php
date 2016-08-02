<?php

namespace App\Http\Middleware;

use Closure;
use App\Core\Language\Manager as LngManager;
use Exception;

class Front
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
        $request = request();
        if ($request->path() === '/') {
            header("HTTP/1.1 301 Moved Permanently");
            header('Location: en/', true, 301);
            exit();
        }
        try {
            $lngCode = $request->segment(1);
            if (strlen($lngCode) === 2) {
                $lngManager = new LngManager();
                $lngManager->setCurrentLanguageByCode($request->segment(1));
            } else {
                abort(404);
            }
        } catch (Exception $e) {
            abort(404);
        };

        if (cLng('code') == 'hy') {
            setlocale(LC_ALL, 'hy_AM.UTF-8');
        } else if (cLng('code') == 'ru') {
            setlocale(LC_ALL, 'ru_RU.UTF-8');
        }

        return $next($request);
    }
}
