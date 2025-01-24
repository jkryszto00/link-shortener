<?php declare(strict_types=1);

namespace App\Providers;

use App\QueryBuilders\Contracts\LinkClickQueryBuilderInterface;
use App\QueryBuilders\LinkClickQueryBuilder;
use App\Repositories\Contracts\LinkClickRepositoryInterface;
use App\Repositories\Contracts\LinkRepositoryInterface;
use App\Repositories\LinkClickRepository;
use App\Repositories\LinkRepository;
use App\Services\BotDetectionService;
use App\Services\ClickTrackingService;
use App\Services\Contracts\BotDetectionServiceInterface;
use App\Services\Contracts\ClickTrackingServiceInterface;
use App\Services\Contracts\DeviceDetectionServiceInterface;
use App\Services\Contracts\GeolocationServiceInterface;
use App\Services\DeviceDetectionService;
use App\Services\GeolocationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        /**
         * Repositories
         */
        LinkRepositoryInterface::class => LinkRepository::class,
        LinkClickRepositoryInterface::class => LinkClickRepository::class,

        /**
         * Query builders
         */
        LinkClickQueryBuilderInterface::class => LinkClickQueryBuilder::class,

        /**
         * Services
         */
        ClickTrackingServiceInterface::class => ClickTrackingService::class,
        BotDetectionServiceInterface::class => BotDetectionService::class,
        DeviceDetectionServiceInterface::class => DeviceDetectionService::class,
        GeolocationServiceInterface::class => GeolocationService::class
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Model::shouldBeStrict();
        Vite::prefetch(concurrency: 3);
    }
}
