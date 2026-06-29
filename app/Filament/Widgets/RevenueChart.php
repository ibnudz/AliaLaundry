<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Tren Pendapatan 7 Hari';

    protected function getData(): array
    {
        $data = collect();
        $labels = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Order::where('payment_status', 'Paid')
                ->whereDate('updated_at', $date)
                ->sum('total_price');

            $data->push($revenue);
            $labels->push($date->format('d M'));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => $data->toArray(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
