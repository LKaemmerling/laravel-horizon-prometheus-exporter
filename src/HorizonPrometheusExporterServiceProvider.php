<?php

namespace LKDevelopment\HorizonPrometheusExporter;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class HorizonPrometheusExporterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('horizon-exporter.php'),
            ], 'config');
        }
        $this->app->booted(function () {
            $this->routes();
        });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'horizon-exporter');
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        if (config('horizon-exporter.enabled')) {
            Route::middleware(config('horizon-exporter.middleware'))->group(
                __DIR__ . '/../routes/api.php'
            );
        }
    }
}
