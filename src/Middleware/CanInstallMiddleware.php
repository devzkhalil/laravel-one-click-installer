<?php

namespace Devzkhalil\Installer\Middleware;

use Closure;

class CanInstallMiddleware
{
    public function handle($request, Closure $next)
    {
        $filePath = storage_path('framework/installed.php');

        // check if the file exists
        if (file_exists($filePath)) {
            abort(404);
        }

        return $next($request);
    }
}
