<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArticlesStatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $window = 30;
        $cacheTtlSeconds = 300; // 5 minutes

        $total = cache()->remember(
            "widgets:articles:total",
            now()->addSeconds($cacheTtlSeconds),
            fn() => Article::query()->count(),
        );

        $publishedTotal = cache()->remember(
            "widgets:articles:published:total",
            now()->addSeconds($cacheTtlSeconds),
            fn() => Article::query()->published()->count(),
        );

        $publishedWindow = cache()->remember(
            "widgets:articles:published:{$window}",
            now()->addSeconds($cacheTtlSeconds),
            fn() => Article::query()
                ->published()
                ->where('submitted_at', '>=', now()->subDays($window))
                ->count(),
        );

        $awaiting = cache()->remember(
            "widgets:articles:awaiting",
            now()->addSeconds(60),
            fn() => Article::query()->awaitingApproval()->count(),
        );

        return [
            Stat::make('Articles', number_format($total))
                ->description('Total articles')
                ->icon('heroicon-o-newspaper'),

            Stat::make('Published', number_format($publishedTotal))
                ->description('All-time approved')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make("Published ({$window}d)", number_format($publishedWindow))
                ->description("Approved in last {$window} days")
                ->color('info')
                ->icon('heroicon-o-check-badge'),

            Stat::make('Awaiting Approval', number_format($awaiting))
                ->description('Submitted but not approved')
                ->color('warning')
                ->icon('heroicon-o-clock'),
        ];
    }
}
