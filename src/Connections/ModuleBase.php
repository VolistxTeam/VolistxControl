<?php

namespace Volistx\Control\Connections;

use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Volistx\Control\Helpers\Messages;
use Volistx\Validation\Traits\HasKernelValidations;

class ModuleBase
{
    protected Client $client;
    protected string $module;
    protected string $user_id;
    use HasKernelValidations;
}