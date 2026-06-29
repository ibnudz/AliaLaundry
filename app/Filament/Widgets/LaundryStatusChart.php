<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class LaundryStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Distribusi Status Cucian';

    protected function getData(): array
    {
        $statuses = ['Pending Confirmation', 'Queued', 'Washing', 'Ironing', 'Completed', 'Picked Up'];
        $counts = [];

        foreach ($statuses as $status) {
            $counts[] = Order::where('laundry_status', $status)->count();
        }

        return [
            'datasets' => [
                [
                    'data' => $counts,
                    'backgroundColor' => [
                        '#f59e0b',
                        '#3b82f6',
                        '#8b5cf6',
                        '#f97316',
                        '#22c55e',
                        '#6b7280',
                    ],
                ],
            ],
            'labels' => $statuses,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
