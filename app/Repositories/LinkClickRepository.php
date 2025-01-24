<?php declare(strict_types=1);

namespace App\Repositories;

use App\DataTransferObjects\ClickTrackingDto;
use App\Models\LinkClick;
use App\QueryBuilders\LinkClickQueryBuilder;
use App\Repositories\Contracts\LinkClickRepositoryInterface;
use App\ValueObjects\DeviceInfo;
use App\ValueObjects\GeolocationData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class LinkClickRepository implements LinkClickRepositoryInterface
{
    public function __construct(
        private readonly LinkClickQueryBuilder $queryBuilder
    ){}

    public function create(int $linkId, ClickTrackingDto $clickTrackingDto, GeolocationData $geolocationData, ?DeviceInfo $deviceInfo = null): LinkClick
    {
        return LinkClick::create([
            'link_id' => $linkId,
            'ip_address' => $clickTrackingDto->ipAddress,
            'user_agent' => $clickTrackingDto->userAgent,
            'country' => $geolocationData->country,
            'city' => $geolocationData->city,
            'browser' => $deviceInfo?->browser,
            'browser_version' => $deviceInfo?->browserVersion,
            'platform' => $deviceInfo?->platform,
            'platform_version' => $deviceInfo?->platformVersion,
            'device_type' => $deviceInfo?->deviceType->value,
            'device_name' => $deviceInfo?->deviceName,
        ]);
    }

    public function getTotalClicks(int $linkId): int
    {
        return Cache::remember(
            "link_total_clicks_{$linkId}",
            900,
            fn() => $this->queryBuilder->getTotalClicks($linkId)
        );
    }

    public function getClicksByPeriod(int $linkId): Collection
    {
        return Cache::remember(
            "link_clicks_period_{$linkId}",
            900,
            fn() => $this->queryBuilder->getClicksByPeriod($linkId)
        );
    }

    public function getClicksByCountry(int $linkId, int $limit = 10): Collection
    {
        return Cache::remember(
            "link_country_stats_{$linkId}",
            900,
            fn() => $this->queryBuilder->getClicksByCountry($linkId, $limit)
        );
    }

    public function getClicksByDevice(int $linkId, int $limit = 10): Collection
    {
        return Cache::remember(
            "link_device_stats_{$linkId}",
            900,
            fn() => $this->queryBuilder->getClicksByDevice($linkId, $limit)
        );
    }

    public function getClicksByBrowser(int $linkId, int $limit = 10): Collection
    {
        return Cache::remember(
            "link_browser_stats_{$linkId}",
            900,
            fn() => $this->queryBuilder->getClicksByBrowser($linkId, $limit)
        );
    }
}
