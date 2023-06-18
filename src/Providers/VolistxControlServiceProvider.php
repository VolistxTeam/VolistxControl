<?php

namespace Volistx\Control\Providers;

use Illuminate\Support\ServiceProvider;
use Volistx\Control\VolistxControl;

class VolistxControlServiceProvider extends ServiceProvider
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
        $this->app->bind('VolistxControl', function () {
            return new VolistxControl();
        });
    }
}