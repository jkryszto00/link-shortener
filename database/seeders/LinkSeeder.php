<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Link;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LinkSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $user = User::first() ?? User::factory()->create();

        $links = [
            [
                'title' => 'My Portfolio',
                'url' => 'https://www.myportfolio.com/profile',
                'short_code' => 'port',
                'total_clicks' => 42
            ],
            [
                'title' => 'GitHub Profile',
                'url' => 'https://github.com/username',
                'short_code' => 'gh',
                'total_clicks' => 157
            ],
            [
                'title' => 'Personal Blog',
                'url' => 'https://www.myblog.com/latest-posts',
                'short_code' => 'blog',
                'total_clicks' => 23
            ]
        ];

        foreach ($links as $linkData) {
            $link = Link::create([
                'user_id' => $user->id,
                'title' => $linkData['title'],
                'url' => $linkData['url'],
                'short_code' => $linkData['short_code'],
                'total_clicks' => $linkData['total_clicks']
            ]);

            $this->createLinkClicks($link, $linkData['total_clicks']);
        }
    }

    private function createLinkClicks(Link $link, int $totalClicks): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < $totalClicks; $i++) {
            $link->clicks()->create([
                'ip_address' => $faker->ipv4,
                'user_agent' => $faker->userAgent,
                'country' => $faker->country,
                'city' => $faker->city,
                'browser' => $this->getBrowser($faker->userAgent),
                'browser_version' => $faker->randomFloat(1, 80, 120),
                'platform' => $this->getPlatform($faker->userAgent),
                'platform_version' => $faker->randomFloat(1, 10, 20),
                'device_type' => $this->getDeviceType($faker->userAgent),
                'device_name' => $faker->randomElement(['iPhone', 'Android', 'Desktop', 'Tablet'])
            ]);
        }
    }

    private function getBrowser(string $userAgent): ?string
    {
        $browsers = [
            'Chrome' => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari' => 'Safari',
            'Edge' => 'Edge'
        ];

        foreach ($browsers as $browser => $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return $browser;
            }
        }

        return null;
    }

    private function getPlatform(string $userAgent): ?string
    {
        $platforms = [
            'Windows' => 'Windows',
            'Mac' => 'Macintosh',
            'Linux' => 'Linux',
            'iOS' => 'iPhone',
            'Android' => 'Android'
        ];

        foreach ($platforms as $platform => $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return $platform;
            }
        }

        return null;
    }

    private function getDeviceType(string $userAgent): ?string
    {
        if (stripos($userAgent, 'Mobile') !== false) return 'Mobile';
        if (stripos($userAgent, 'Tablet') !== false) return 'Tablet';
        if (stripos($userAgent, 'iPhone') !== false) return 'Mobile';
        if (stripos($userAgent, 'Android') !== false) return 'Mobile';
        return 'Desktop';
    }
}
