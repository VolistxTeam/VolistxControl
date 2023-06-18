<?php

namespace Volistx\Control;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class VolistxControl
{
    protected $config;
    /**
     * @var \ArrayAccess|mixed
     */
    protected $service;

    public function __construct(string $service)
    {
        $this->getService($service);
    }

    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    public function getService()
    {
        if ($this->service === null) {
            // Get service configuration
            $config = $this->config('services.' . $this->service, []);

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
