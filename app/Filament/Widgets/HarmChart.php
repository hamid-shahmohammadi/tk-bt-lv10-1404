<?php

namespace App\Filament\Widgets;

use App\Models\Harm;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class HarmChart extends ChartWidget
{
    protected static ?string $heading = 'خسارات';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Trend::model(Harm::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'خسارات',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
