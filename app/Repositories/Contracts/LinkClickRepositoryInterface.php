<?php declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\DataTransferObjects\ClickTrackingDto;
use App\Models\LinkClick;
use App\ValueObjects\DeviceInfo;
use App\ValueObjects\GeolocationData;
use Illuminate\Support\Collection;

interface LinkClickRepositoryInterface
{
    public function create(int $linkId, ClickTrackingDto $clickTrackingDto, GeolocationData $geolocationData, ?DeviceInfo $deviceInfo): LinkClick;
    public function getTotalClicks(int $linkId): int;
    public function getClicksByPeriod(int $linkId): Collection;
    public function getClicksByCountry(int $linkId, int $limit = 10): Collection;
    public function getClicksByDevice(int $linkId, int $limit = 10): Collection;
    public function getClicksByBrowser(int $linkId, int $limit = 10): Collection;
}
