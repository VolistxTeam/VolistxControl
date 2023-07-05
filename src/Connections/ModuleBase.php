<?php

namespace Volistx\Control\Connections;

use GuzzleHttp\Client;
use Volistx\Validation\Traits\HasKernelValidations;

class ModuleBase
{
    protected Client $client;

    protected string $module;

    protected string $user_id;

    use HasKernelValidations;

    protected function SanitizeInputs(&$inputs): void
    {
        $inputs = array_filter($inputs, function ($x) {
            return $x !== null;
        });
    }
}
