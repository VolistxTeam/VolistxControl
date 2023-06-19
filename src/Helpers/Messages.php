<?php

namespace Volistx\Control\Helpers;

class Messages
{
    public static function Error($type, $info): array
    {
        return [
            'error' => [
                'type' => $type,
                'info' => $info,
            ],
        ];
    }

    public static function E400($error = null): array
    {
        return self::Error('InvalidParameter', $error ?? trans('volistx-control::error.e400'));
    }

    public static function E401($error = null): array
    {
        return self::Error('Unauthorized', $error ?? trans('volistx-control::error.e401'));
    }

    public static function E403($error = null): array
    {
        return self::Error('Forbidden', $error ?? trans('volistx-control::error.e403'));
    }

    public static function E404($error = null): array
    {
        return self::Error('NotFound', $error ?? trans('volistx-control::error.e404'));
    }

    public static function E409($error = null): array
    {
        return self::Error('Conflict', $error ?? trans('volistx-control::error.e409'));
    }

    public static function E429($error = null): array
    {
        return self::Error('RateLimitReached', $error ?? trans('volistx-control::error.e429'));
    }

    public static function E500($error = null): array
    {
        return self::Error('Unknown', $error ?? trans('volistx-control::error.e500'));
    }
}