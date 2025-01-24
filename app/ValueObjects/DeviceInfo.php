<?php declare(strict_types=1);

namespace App\ValueObjects;

use App\Enums\DeviceType;

final class DeviceInfo
{
    public function __construct(
        public string $browser,
        public string $browserVersion,
        public string $platform,
        public string $platformVersion,
        public DeviceType $deviceType,
        public ?string $deviceName = null
    ) {}
}
