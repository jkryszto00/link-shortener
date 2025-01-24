<?php declare(strict_types=1);

namespace App\DataTransferObjects;

use App\ValueObjects\ShortCode;

readonly final class CreateLinkDto
{
    public function __construct(
        public int $userId,
        public ?string $title,
        public string $url,
        public ShortCode $shortCode,
    ){}
}
