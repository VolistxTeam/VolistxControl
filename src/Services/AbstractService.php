<?php

namespace Volistx\Control\Services;
use Volistx\Control\Contracts\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}