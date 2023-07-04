<?php

namespace Volistx\Control;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Volistx\Control\Services\ServiceManager;

class VolistxControlManager
{
    public function getService($service): ServiceManager
    {
        // Get service configuration
        $config = Config::get('volistx-control.services.'.$service, []);

        // Create service instance
        return new ServiceManager($config);
    }
}
