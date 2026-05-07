<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class UpdateArticleViewCounts extends Command
{
    protected $signature = 'lio:update-article-view-counts';

    protected $description = 'Queries the Fathom Analytics API to update the view counts for all articles';

    protected $siteId;

    protected $token;

    public function __construct()
    {
        parent::__construct();

        $this->siteId = config('services.fathom.site_id');
        $this->token = config('services.fathom.token');
    }

    public function handle(): void
    {
        if (! $this->siteId || ! $this->token) {
            $this->error('Fathom site ID and token must be configured');

            return;
        }

        $articles = Article::query()
            ->without(['authorRelation', 'likesRelation', 'likersRelation', 'tagsRelation'])
            ->published()
            ->get(['id', 'slug', 'original_url']);

        $viewCounts = $this->getViewCountsFor($articles);

        if ($viewCounts === null) {
            if ($this->output) {
                $this->error('Failed to get article view counts from Fathom');
            }

            return;
        }

        $articles->each(function (Article $article) use ($viewCounts) {
            $article->timestamps = false;
            $article->view_count = $this->getViewCountFor($article, $viewCounts);
            $article->save();
        });
    }

    protected function getViewCountFor(Article $article, Collection $viewCounts): ?int
    {
        $viewCount = $viewCounts->get($this->getUrlKey(route('articles.show', $article->slug)), 0);
        $canonicalViewCount = ($url = $article->originalUrl()) ? $viewCounts->get($this->getUrlKey($url), 0) : 0;

        return ($total = $viewCount + $canonicalViewCount) > 0 ? $total : null;
    }

    protected function getViewCountsFor(Collection $articles): ?Collection
    {
        $urls = $articles
            ->flatMap(fn (Article $article) => array_filter([
                route('articles.show', $article->slug),
                $article->originalUrl(),
            ]))
            ->map(fn (string $url) => $this->parseUrl($url))
            ->filter()
            ->unique(fn (array $url) => $this->getUrlKey($url))
            ->values();

        $viewCounts = collect();

        foreach ($urls->pluck('path')->unique()->chunk(100) as $paths) {
            $response = $this->getViewCountsForPaths($paths);

            if ($response === null) {
                return null;
            }

            foreach ($response as $row) {
                if (! isset($row['hostname'], $row['pathname'], $row['pageviews'])) {
                    continue;
                }

                $key = $this->getUrlKey([
                    'hostname' => $row['hostname'],
                    'path' => $row['pathname'],
                ]);

                $viewCounts->put($key, $viewCounts->get($key, 0) + (int) $row['pageviews']);
            }
        }

        return $viewCounts;
    }

    protected function getViewCountsForPaths(Collection $paths): ?array
    {
        $filters = [[
            'property' => 'pathname',
            'operator' => 'matching',
            'value' => '^('.$paths->map(fn (string $path) => preg_quote($path, '/'))->implode('|').')$',
        ]];

        $response = Http::retry(3, 100, null, false)->acceptJson()->withToken($this->token)
            ->get('https://api.usefathom.com/v1/aggregations', [
                'date_from' => '2021-03-01 00:00:00', // Fathom data aggregations not accurate prior to this date.
                'field_grouping' => 'hostname,pathname',
                'entity' => 'pageview',
                'aggregates' => 'pageviews',
                'entity_id' => $this->siteId,
                'filters' => json_encode($filters),
            ]);

        if ($response->failed()) {
            logger()->error('Failed to get view counts from Fathom', [
                'paths' => $paths->all(),
                'response' => $response->json(),
            ]);

            return null;
        }

        return $response->json();
    }

    protected function getUrlKey(null|array|string $url): ?string
    {
        if (! $url = is_array($url) ? $url : $this->parseUrl($url)) {
            return null;
        }

        return "{$url['hostname']}{$url['path']}";
    }

    protected function parseUrl(string $url): ?array
    {
        if (! $url = parse_url($url)) {
            return null;
        }

        $scheme = $url['scheme'] ?? null;
        $host = $url['host'] ?? null;
        $path = $url['path'] ?? null;

        if (! $scheme || ! $host || ! $path) {
            return null;
        }

        return [
            'hostname' => "{$scheme}://{$host}",
            'path' => $path,
        ];
    }
}
