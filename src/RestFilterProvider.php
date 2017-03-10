<?php

namespace Jimb\RestFilter;

use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use Jimb\RestFilter\FractalAdapter;

class RestFilterProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Fractal', function () {
            return new Manager();
        });

        $this->app->bind('RestFilter', function () {
            return FractalAdapter::getInstance();
        });
    }
}
