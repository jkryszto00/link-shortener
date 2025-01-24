<?php declare(strict_types=1);

namespace App\QueryBuilders\Contracts;

use Illuminate\Support\Collection;

interface LinkClickQueryBuilderInterface
{
    public function getTotalClicks(int $linkId): int;
    public function getClicksByPeriod(int $linkId): Collection;
    public function getClicksByCountry(int $linkId, int $limit = 10): Collection;
    public function getClicksByDevice(int $linkId, int $limit = 10): Collection;
    public function getClicksByBrowser(int $linkId, int $limit = 10): Collection;
}
