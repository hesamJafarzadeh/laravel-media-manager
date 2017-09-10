<?php

namespace MediaManager\Manager;

use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/config/manager.php', 'manager');
        $this->app->bind('Source', function () {return new \MediaManager\Manager\Source;});
    }
}
