<?php

namespace Volistx\Control\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method \Volistx\Control\VolistxControl getService(string $service)
 *
 * @see \Volistx\Control\VolistxControl
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