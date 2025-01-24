<?php declare(strict_types=1);

namespace App\Services\Contracts;

use App\ValueObjects\GeolocationData;

interface GeolocationServiceInterface
{
    public function locate(string $ipAddress): GeolocationData;
}
