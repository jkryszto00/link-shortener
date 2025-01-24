<?php declare(strict_types=1);

namespace App\DataTransferObjects;

readonly final class ClickTrackingDto
{
    public function __construct(
        public string $ipAddress,
        public ?string $userAgent,
        public ?string $referer = null
    ) {}
}
