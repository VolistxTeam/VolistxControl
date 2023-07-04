<?php

namespace Volistx\Control\Facades;

use Illuminate\Support\Facades\Facade;
use Volistx\Control\Services\ServiceManager;

/**
 * @method ServiceManager getService(string $service)
 */
class VolistxControl extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'VolistxControl';
    }
}
