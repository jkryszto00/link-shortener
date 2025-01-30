<?php

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
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        /**
         * Services
         */
        BotDetectionServiceInterface::class => BotDetectionService::class,
        ClickTrackingServiceInterface::class => ClickTrackingService::class,
        DeviceDetectionServiceInterface::class => DeviceDetectionService::class,
        GeolocationServiceInterface::class => GeolocationService::class,

        /**
         * Repositories
         */
        LinkRepositoryInterface::class => LinkRepository::class,
        LinkClickRepositoryInterface::class => LinkClickRepository::class,

        /**
         * QueryBuilders
         */
        LinkClickQueryBuilderInterface::class => LinkClickQueryBuilder::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
