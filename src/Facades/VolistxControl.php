<?php

namespace Volistx\Control\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getService(string $getService)
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