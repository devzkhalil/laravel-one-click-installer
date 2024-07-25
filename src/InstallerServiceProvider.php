<?php

namespace Devzkhalil\Installer;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Devzkhalil\Installer\Middleware\CanInstallMiddleware;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/installer.php',
            'installer'
        );

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'installer');
    }

    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstallMiddleware::class]);

        $this->publishes([
            __DIR__ . '/config/installer.php' => config_path('installer.php'),
        ], 'installer-config');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/installer'),
        ], 'installer-views');

        $this->publishes([
            __DIR__ . '/public' => public_path('vendor/installer'),
        ], 'installer-assets');
    }
}
