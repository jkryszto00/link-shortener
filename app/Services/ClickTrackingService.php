<?php declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\ClickTrackingDto;
use App\Models\LinkClick;
use App\Repositories\Contracts\LinkClickRepositoryInterface;
use App\Repositories\Contracts\LinkRepositoryInterface;
use App\Services\Contracts\BotDetectionServiceInterface;
use App\Services\Contracts\ClickTrackingServiceInterface;
use App\Services\Contracts\DeviceDetectionServiceInterface;
use App\Services\Contracts\GeolocationServiceInterface;

class ClickTrackingService implements ClickTrackingServiceInterface
{
    public function __construct(
        private LinkRepositoryInterface $linkRepository,
        private LinkClickRepositoryInterface $linkClickRepository,
        private BotDetectionServiceInterface $botDetectionService,
        private GeolocationServiceInterface $geolocationService,
        private DeviceDetectionServiceInterface $deviceDetectionService
    ){}

    public function track(int $linkId, ClickTrackingDto $clickTrackingDto): ?LinkClick
    {
        if (!$this->botDetectionService->isBot($clickTrackingDto->userAgent)) {
            $geoData = $this->geolocationService->locate($clickTrackingDto->ipAddress);
            $deviceInfo = $this->deviceDetectionService->detect($clickTrackingDto->userAgent);

            $this->linkRepository->incrementClickCount($linkId);

            return $this->linkClickRepository->create($linkId, $clickTrackingDto, $geoData, $deviceInfo);
        }

        return null;
    }
}
