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
        if ($this->app->runningInConsole()) {
            $this->registerResources();
        }

        if ($this->isLumen() === false) {
            $this->mergeConfigFrom(__DIR__ . '/../config/volistx-control.php', 'volistx-control');
        }

        $this->app->register(VolistxControlServiceProvider::class);

        $this->publishes([
            __DIR__ . '/../config/volistx-control.php' => config_path('volistx-control.php'),
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ]);
    }

    /**
     * Register resources.
     *
     * @return void
     */
    public function registerResources()
    {
        if ($this->isLumen() === false) {
            $this->publishes([
                __DIR__ . '/../config/volistx-control.php' => config_path('volistx-control.php'),
            ], 'config');
        }
    }

    /**
     * Check if package is running under Lumen app
     *
     * @return bool
     */
    protected function isLumen()
    {
        return Str::contains($this->app->version(), 'Lumen') === true;
    }

}
