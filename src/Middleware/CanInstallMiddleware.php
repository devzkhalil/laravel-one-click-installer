<?php

namespace Devzkhalil\Installer\Middleware;

use Closure;

class CanInstallMiddleware
{
    public function handle($request, Closure $next)
    {
        if (config('installer.installed')) {
            abort(404);
        }
        
        return $next($request);
    }
}
