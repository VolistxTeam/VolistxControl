<?php

namespace Volistx\Control\Facades;

use Illuminate\Support\Facades\Facade;

class VolistxControlFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'volistxcontrol';
    }
}