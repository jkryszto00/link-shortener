<?php declare(strict_types=1);

namespace App\DataTransferObjects;

readonly final class UpdateLinkDto
{
    public function __construct(
        public ?string $title,
        public string $url
    ){}
}
