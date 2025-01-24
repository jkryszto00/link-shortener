<?php declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\ClickTrackingDto;
use App\Services\Contracts\ClickTrackingServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class TrackLinkClickJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;

    public array $backoff = [1, 5, 10];

    public function __construct(
        private readonly int $linkId,
        private readonly ClickTrackingDto $clickData
    ){}

    public function handle(ClickTrackingServiceInterface $clickTrackingService): void
    {
        try {
            $clickTrackingService->track($this->linkId, $this->clickData);
        } catch (\Exception $e) {
            Log::error('Link click tracking failed', [
                'link_id' => $this->linkId,
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    public function failed(?\Throwable $exception): void
    {
        Log::critical('Link click tracking completely failed', [
            'link_id' => $this->linkId,
            'error' => $exception->getMessage()
        ]);
    }
}
