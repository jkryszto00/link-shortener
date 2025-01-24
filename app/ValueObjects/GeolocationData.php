<?php declare(strict_types=1);

namespace App\ValueObjects;

final class GeolocationData
{
    public function __construct(
        public ?string $country,
        public ?string $city,
        public ?float $latitude,
        public ?float $longitude
    ) {}
}
