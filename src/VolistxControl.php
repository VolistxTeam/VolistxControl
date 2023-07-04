<?php

namespace Volistx\Control;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Volistx\Control\Services\BasicService;

class VolistxControl
{
    public function getService($service): BasicService
    {
        // Get service configuration
        $config = Config::get('volistx-control.services.'.$service, []);

        // Get service class
        $class = Arr::pull($config, 'class');

        // Sanity check
        if ($class === null) {
            throw new Exception('The Volistx service is not valid.');
        }

        // Create service instance
        return app($class, ['config' => $config]);
    }
}
