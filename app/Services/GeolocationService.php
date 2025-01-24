<?php declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\GeolocationServiceInterface;
use App\ValueObjects\GeolocationData;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeolocationService implements GeolocationServiceInterface
{
    private const CACHE_TTL = 30 * 24 * 60; // 30 days

    public function locate(string $ipAddress): GeolocationData
    {
        $cacheKey = "geo_ip:{$ipAddress}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($ipAddress) {
            $response = Http::get("https://ipapi.co/{$ipAddress}/json/")->json();

            return new GeolocationData(
                country: $response['country_name'] ?? null,
                city: $response['city'] ?? null,
                latitude: $response['latitude'] ?? null,
                longitude: $response['longitude'] ?? null
            );
        });
    }
}
