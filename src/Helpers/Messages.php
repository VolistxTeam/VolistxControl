<?php

namespace Volistx\Control\Helpers;

class Messages
{
    public function Error($type, $info): array
    {
        return [
            'error' => [
                'type' => $type,
                'info' => $info,
            ],
        ];
    }

    public function E400($error = null): array
    {
        return self::Error('InvalidParameter', $error ?? 'One or more invalid parameters were specified.');
    }

    public function E401($error = null): array
    {
        return self::Error('Unauthorized', $error ?? 'You have insufficient permissions to access this resource.');
    }

    public function E403($error = null): array
    {
        return self::Error('Forbidden', $error ?? "You don't have permission to access this resource.");
    }

    public function E404($error = null): array
    {
        return self::Error('NotFound', $error ?? "The requested resource could not be found.");
    }

    public function E409($error = null): array
    {
        return self::Error('Conflict', $error ?? 'The request could not be completed due to a conflict with the current state of the resource.');
    }

    public function E429($error = null): array
    {
        return self::Error('RateLimitReached', $error ?? 'You have exceeded the rate limit for this resource.');
    }

    public function E500($error = null): array
    {
        return self::Error('Unknown', $error ?? 'An unexpected error occurred.');
    }
}