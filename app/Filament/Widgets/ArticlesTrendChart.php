<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ArticlesTrendChart extends ChartWidget
{
    protected ?string $heading = 'Articles per Month';
    protected ?string $pollingInterval = '30s';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Trend::model(Article::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Submitted',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'tension' => 0.35,
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('M Y')),
        ];
    }
}
