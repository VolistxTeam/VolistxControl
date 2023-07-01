<?php

namespace Volistx\Control\Enums;

enum Service: string
{
    case GEO_POINT = 'geo-point';
    case BIN_POINT = 'bin-point';
    case USER_POINT = 'user-point';
}
