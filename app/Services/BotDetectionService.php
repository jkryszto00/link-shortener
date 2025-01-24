<?php declare(strict_types=1);

namespace App\Services;

use App\Services\Contracts\BotDetectionServiceInterface;
use Jenssegers\Agent\Agent;

class BotDetectionService implements BotDetectionServiceInterface
{
    private const BOT_PATTERNS = [
        'bot', 'crawl', 'spider', 'curl', 'wget',
        'python-requests', 'java', 'Apache',
        'Googlebot', 'bingbot', 'YandexBot'
    ];

    public function isBot(?string $userAgent): bool
    {
        if (empty($userAgent)) {
            return true;
        }

        $agent = new Agent();
        $agent->setUserAgent($userAgent);

        return $this->matchesBotPatterns($userAgent) || $agent->isRobot();
    }

    private function matchesBotPatterns(string $userAgent): bool
    {
        return collect(self::BOT_PATTERNS)
            ->some(fn($pattern) => stripos($userAgent, $pattern) !== false);
    }
}
