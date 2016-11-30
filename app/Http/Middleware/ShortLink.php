<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ShortLink\ShortLinkManager;
use Cache;

class ShortLink
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
        $url = $request->fullUrl();

        $shortLinks = ShortLinkManager::all();
        if (isset($shortLinks[$url])) {
            header("HTTP/1.1 301 Moved Permanently");
            header('Location: '.$shortLinks[$url]->link, true, 301);
            exit();
        }

        return $next($request);
    }
}
