<?php declare(strict_types=1);

namespace App\ValueObjects;

final class ShortCode
{
    public function __construct(
        private string $value
    ){
        if (!preg_match('/^[a-zA-Z0-9]{6,8}$/', $this->value)) {
            throw new \InvalidArgumentException('Invalid short code format');
        }
    }

    public static function generate(): self
    {
        return new self(bin2hex(random_bytes(4)));
    }

    public static function fromString(string $code): self
    {
        return new self($code);
    }

    public function toString(): string
    {
        return $this->value;
    }
}
