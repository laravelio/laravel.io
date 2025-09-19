<?php

namespace App\Filament\Widgets;

use App\Models\User;
// No form usage in Filament v4 widgets; using plain logic.
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersStatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $window = 30;
        $cacheTtlSeconds = 300;

        $total = cache()->remember(
            'widgets:users:total',
            now()->addSeconds($cacheTtlSeconds),
            fn () => User::query()->count(),
        );

        $lastWindow = cache()->remember(
            "widgets:users:new:{$window}",
            now()->addSeconds($cacheTtlSeconds),
            fn () => User::query()->where('created_at', '>=', now()->subDays($window))->count(),
        );

        $verified = cache()->remember(
            'widgets:users:verified',
            now()->addSeconds($cacheTtlSeconds),
            fn () => User::query()->whereNotNull('author_verified_at')->count(),
        );

        return [
            Stat::make('Users', number_format($total))
                ->description('Total registered')
                ->icon('heroicon-o-users'),

            Stat::make("New ({$window}d)", number_format($lastWindow))
                ->description("Joined in last {$window} days")
                ->color('info')
                ->icon('heroicon-o-user-plus'),

            Stat::make('Verified Authors', number_format($verified))
                ->description('Users verified as authors')
                ->color('success')
                ->icon('heroicon-o-check'),
        ];
    }
}
