<?php declare(strict_types=1);

namespace App\Repositories;

use App\DataTransferObjects\CreateLinkDto;
use App\DataTransferObjects\UpdateLinkDto;
use App\Models\Link;
use App\Repositories\Contracts\LinkRepositoryInterface;
use App\ValueObjects\ShortCode;
use Illuminate\Support\Collection;

class LinkRepository implements LinkRepositoryInterface
{
    public function getUserLinks(int $userId): Collection
    {
        return Link::query()->where("user_id", $userId)->latest()->get();
    }

    public function findById(int $id): ?Link
    {
        return Link::query()->findOrFail($id);
    }

    public function findByShortCode(ShortCode $shortCode): ?Link
    {
        return Link::query()->where('short_code', $shortCode->toString())->firstOrFail();
    }

    public function create(CreateLinkDto $createLinkDto): Link
    {
        return Link::create([
            'user_id' => $createLinkDto->userId,
            'title' => $createLinkDto->title,
            'url' => $createLinkDto->url,
            'short_code' => $createLinkDto->shortCode->toString()
        ]);
    }

    public function incrementClickCount(int $id): void
    {
        $link = $this->findById($id);
        $link->increment('total_clicks');
    }

    public function update(int $id, UpdateLinkDto $updateLinkDto): Link
    {
        $link = $this->findById($id);
        $link->update([
            'title' => $updateLinkDto->title,
            'url' => $updateLinkDto->url
        ]);

        return $link;
    }

    public function delete(int $id): void
    {
        $link = $this->findById($id);
        $link->delete();
    }
}
