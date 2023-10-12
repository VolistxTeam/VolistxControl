<?php

namespace Volistx\Control;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Volistx\Control\Providers\VolistxControlServiceProvider;

class VolistxControlProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(VolistxControlServiceProvider::class);
    }
}
