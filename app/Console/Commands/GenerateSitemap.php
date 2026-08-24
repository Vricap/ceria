<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Support\ServiceItem;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap.';

    public function handle()
    {
        $this->info('Generating sitemap...');

        // Base URL produksi yang tetap — tidak bergantung APP_URL agar
        // sitemap selalu valid meskipun command dijalankan via cron/CLI.
        $base = rtrim(config('seo.base_url'), '/');

        $sitemap = Sitemap::create();

        $staticPages = [
            '/'          => ['priority' => 1.0, 'freq' => Url::CHANGE_FREQUENCY_DAILY],
            '/properti'  => ['priority' => 0.9, 'freq' => Url::CHANGE_FREQUENCY_DAILY],
            '/tentang'   => ['priority' => 0.8, 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/layanan'   => ['priority' => 0.8, 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/portfolio' => ['priority' => 0.7, 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
            '/kontak'    => ['priority' => 0.7, 'freq' => Url::CHANGE_FREQUENCY_MONTHLY],
        ];

        foreach ($staticPages as $path => $meta) {
            $sitemap->add(
                Url::create("{$base}{$path}")
                    ->setPriority($meta['priority'])
                    ->setChangeFrequency($meta['freq'])
            );
        }

        // Detail properti (status tampil: published, featured, sold, rented).
        Property::visible()
            ->select(['slug', 'updated_at'])
            ->chunk(500, function ($properties) use ($sitemap, $base) {
                foreach ($properties as $property) {
                    $sitemap->add(
                        Url::create("{$base}/properti/{$property->slug}")
                            ->setLastModificationDate($property->updated_at)
                            ->setPriority(0.9)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                }
            });

        // Layanan
        foreach (ServiceItem::all() as $service) {
            $sitemap->add(
                Url::create("{$base}/layanan/{$service->slug}")
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully at public/sitemap.xml');
    }
}
