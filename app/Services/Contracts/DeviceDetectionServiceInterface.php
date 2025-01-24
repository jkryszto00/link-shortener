<?php declare(strict_types=1);

namespace App\Services\Contracts;

use App\ValueObjects\DeviceInfo;

interface DeviceDetectionServiceInterface
{
    public function detect(?string $userAgent): ?DeviceInfo;
}
