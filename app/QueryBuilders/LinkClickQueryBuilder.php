<?php declare(strict_types=1);

namespace App\QueryBuilders;

use App\Models\LinkClick;
use App\QueryBuilders\Contracts\LinkClickQueryBuilderInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LinkClickQueryBuilder implements LinkClickQueryBuilderInterface
{
    private function baseQuery(int $linkId)
    {
        return LinkClick::where('link_id', $linkId);
    }

    public function getTotalClicks(int $linkId): int
    {
        return $this->baseQuery($linkId)->count();
    }

    public function getClicksByPeriod(int $linkId): Collection
    {
        $baseQuery = $this->baseQuery($linkId);

        return collect([
            'today' => (clone $baseQuery)->whereDate('created_at', today())->count(),
            'last_7_days' => (clone $baseQuery)->where('created_at', '>=', now()->subDays(7))->count(),
            'last_30_days' => (clone $baseQuery)->where('created_at', '>=', now()->subDays(30))->count()
        ]);
    }

    public function getClicksByCountry(int $linkId, int $limit = 10): Collection
    {
        return $this->baseQuery($linkId)
            ->select('country', DB::raw('COUNT(*) as click_count'))
            ->groupBy('country')
            ->orderByDesc('click_count')
            ->limit($limit)
            ->get();
    }

    public function getClicksByDevice(int $linkId, int $limit = 10): Collection
    {
        return $this->baseQuery($linkId)
            ->select('device_type', DB::raw('COUNT(*) as click_count'))
            ->groupBy('device_type')
            ->orderByDesc('click_count')
            ->limit($limit)
            ->get();
    }

    public function getClicksByBrowser(int $linkId, int $limit = 10): Collection
    {
        return $this->baseQuery($linkId)
            ->select('browser', 'browser_version', DB::raw('COUNT(*) as click_count'))
            ->groupBy('browser', 'browser_version')
            ->orderByDesc('click_count')
            ->limit($limit)
            ->get();
    }
}
