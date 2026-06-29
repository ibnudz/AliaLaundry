<?php

namespace App\Filament\Widgets;

use App\Models\Complaint;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $activeOrders = Order::whereIn('laundry_status', ['Queued', 'Washing', 'Ironing'])->count();

        $revenueToday = Order::where('payment_status', 'Paid')
            ->whereDate('updated_at', today())
            ->sum('total_price');

        $revenueMonth = Order::where('payment_status', 'Paid')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->sum('total_price');

        $pendingComplaints = Complaint::where('complaint_status', 'Pending')->count();

        return [
            Stat::make('Pesanan Aktif', $activeOrders)
                ->description('Queued / Washing / Ironing')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),

            Stat::make('Pendapatan Hari Ini', 'Rp '.number_format($revenueToday, 0, ',', '.'))
                ->color('success'),

            Stat::make('Pendapatan Bulan Ini', 'Rp '.number_format($revenueMonth, 0, ',', '.'))
                ->description('Bulan '.now()->locale('id')->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Keluhan Pending', $pendingComplaints)
                ->description('Menunggu respons')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
