<?php

namespace Volistx\Control;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class VolistxControl
{
    protected $config;

    protected $service;

    public function __construct()
    {
    }

    public function getService($service)
    {
        if ($this->service === null) {
            // Get service configuration
            $config = Config::get('volistx-control.services.' . $service, []);

            // Get service class
            $class = Arr::pull($config, 'class');

            // Sanity check
            if ($class === null) {
                throw new Exception('The Volistx service is not valid.');
            }

            // Create service instance
            $this->service = new $class($config);
        }

        return $this->service;
    }
}
