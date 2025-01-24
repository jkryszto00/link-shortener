<?php declare(strict_types=1);

namespace App\Services\Contracts;

interface BotDetectionServiceInterface
{
    public function isBot(?string $userAgent): bool;
}
