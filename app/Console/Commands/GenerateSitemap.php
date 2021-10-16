<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Console\Command;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Crawl the site to generate a sitemap.xml file';

    private $noIndexPaths = [
        '',
        '/forum/*',
        '/user/*',
    ];

    public function handle()
    {
        SitemapGenerator::create(config('app.url'))
            ->shouldCrawl(function (UriInterface $url) {
                return $this->shouldIndex($url->getPath());
            })
            ->hasCrawled(function (Url $url) {
                if ($this->shouldNotIndex($url->path())) {
                    return;
                }

                return $url;
            })
            ->writeToFile(public_path('sitemap.xml'));
    }

    private function shouldNotIndex($path)
    {
        return Str::is($this->noIndexPaths, $path);
    }

    private function shouldIndex($path)
    {
        return ! $this->shouldNotIndex($path);
    }
}
