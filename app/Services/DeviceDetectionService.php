<?php declare(strict_types=1);

namespace App\Services;

use App\Enums\DeviceType;
use App\Services\Contracts\DeviceDetectionServiceInterface;
use App\ValueObjects\DeviceInfo;
use Jenssegers\Agent\Agent;

class DeviceDetectionService implements DeviceDetectionServiceInterface
{
    public function detect(?string $userAgent): ?DeviceInfo
    {
        if (empty($userAgent)) {
            return null;
        }

        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        return new DeviceInfo(
            browser: $agent->browser() ?? 'Unknown',
            browserVersion: $agent->version($agent->browser()) ?? 'Unknown',
            platform: $agent->platform() ?? 'Unknown',
            platformVersion: $agent->version($agent->platform()) ?? 'Unknown',
            deviceType: $this->determineDeviceType($agent),
            deviceName: $agent->device()
        );
    }

    private function determineDeviceType(Agent $agent): DeviceType
    {
        if ($agent->isDesktop()) return DeviceType::DESKTOP;
        if ($agent->isMobile()) return DeviceType::MOBILE;
        if ($agent->isTablet()) return DeviceType::TABLET;

        return DeviceType::UNKNOWN;
    }
}
