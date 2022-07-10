<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
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

    public function handle()
    {
        if (! $this->siteId || ! $this->token) {
            $this->error('Fathom site ID and token must be configured');

            return;
        }

        Article::published()->chunk(100, function ($articles) {
            $articles->each(function ($article) {
                $article->update([
                    'view_count' => $this->getViewCountFor($article),
                ]);
            });
        });
    }

    protected function getViewCountFor(Article $article): ?int
    {
        $response = Http::withToken($this->token)
            ->get('https://api.usefathom.com/v1/aggregations', [
                'date_from' => '2021-03-01 00:00:00', // Fathom data aggregations not accurate before this date.
                'field_grouping' => 'pathname',
                'entity' => 'pageview',
                'aggregates' => 'pageviews,visits,uniques',
                'entity_id' => $this->siteId,
                'filters' => json_encode([
                    [
                        'property' => 'pathname',
                        'operator' => 'is',
                        'value' => "/articles/{$article->slug()}",
                    ],
                ]),
            ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json('0.pageviews');
    }
}
