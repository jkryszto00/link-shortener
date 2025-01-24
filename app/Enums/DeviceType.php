<?php declare(strict_types=1);

namespace App\Enums;

enum DeviceType: string
{
    case DESKTOP = 'desktop';
    case MOBILE = 'mobile';
    case TABLET = 'tablet';
    case UNKNOWN = 'unknown';
}
