<?php

namespace Volistx\Control;

use Exception;
use Volistx\Control\Services\ServiceManager;

class VolistxControlManager
{
    public function getService(string $base_uri, bool $secure, string $access_key): ServiceManager
    {
        // Get service configuration
        $config = [
            'base_uri' => $base_uri,
            'secure' => $secure,
            'access_key' => $access_key
        ];

        // Create service instance
        return new ServiceManager($config);
    }
}
