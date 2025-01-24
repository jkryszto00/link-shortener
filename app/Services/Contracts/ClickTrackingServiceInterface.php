<?php declare(strict_types=1);

namespace App\Services\Contracts;

use App\DataTransferObjects\ClickTrackingDto;
use App\Models\LinkClick;

interface ClickTrackingServiceInterface
{
    public function track(int $linkId, ClickTrackingDto $clickTrackingDto): ?LinkClick;
}
