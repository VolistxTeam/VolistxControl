<?php

namespace Volistx\Control\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method \Volistx\Control\VolistxControlManager getService(string $service)
 *
 * @see \Volistx\Control\VolistxControlManager
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
