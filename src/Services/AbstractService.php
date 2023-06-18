<?php

namespace Volistx\Control\Services;

use Illuminate\Support\Arr;
use Volistx\Control\Contracts\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    /**
     * Driver config
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new service instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->boot();
    }

    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }
}