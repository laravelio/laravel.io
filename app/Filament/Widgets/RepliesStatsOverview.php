<?php

namespace App\Filament\Widgets;

use App\Models\Reply;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RepliesStatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $window = 30;
        $cacheTtlSeconds = 300;

        $total = cache()->remember(
            'widgets:replies:total',
            now()->addSeconds($cacheTtlSeconds),
            fn () => Reply::query()->count(),
        );

        $lastWindow = cache()->remember(
            "widgets:replies:new:{$window}",
            now()->addSeconds($cacheTtlSeconds),
            fn () => Reply::query()->where('created_at', '>=', now()->subDays($window))->count(),
        );

        $solutions = cache()->remember(
            'widgets:replies:solutions',
            now()->addSeconds($cacheTtlSeconds),
            fn () => Reply::query()->isSolution()->count(),
        );

        return [
            Stat::make('Replies', number_format($total))
                ->description('Total replies')
                ->icon('heroicon-o-chat-bubble-left-right'),

            Stat::make("New ({$window}d)", number_format($lastWindow))
                ->description("Replies in last {$window} days")
                ->color('info')
                ->icon('heroicon-o-chat-bubble-left-ellipsis'),

            Stat::make('Solutions', number_format($solutions))
                ->description('Marked as solution')
                ->color('success')
                ->icon('heroicon-o-sparkles'),
        ];
    }
}
