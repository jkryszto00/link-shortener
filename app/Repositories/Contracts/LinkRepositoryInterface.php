<?php declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\DataTransferObjects\CreateLinkDto;
use App\DataTransferObjects\UpdateLinkDto;
use App\Models\Link;
use App\ValueObjects\ShortCode;
use Illuminate\Support\Collection;

interface LinkRepositoryInterface
{
    public function getUserLinks(int $userId): Collection;
    public function findById(int $id): ?Link;
    public function findByShortCode(ShortCode $shortCode): ?Link;
    public function create(CreateLinkDto $createLinkDto): Link;
    public function incrementClickCount(int $id): void;
    public function update(int $id, UpdateLinkDto $updateLinkDto): Link;
    public function delete(int $id): void;
}
