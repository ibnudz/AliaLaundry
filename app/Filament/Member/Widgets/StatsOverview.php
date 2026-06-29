<?php

namespace App\Filament\Member\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = Auth::id();

        $activeOrders = Order::where('user_id', $userId)
            ->whereNotIn('laundry_status', ['Completed', 'Picked Up'])
            ->count();

        $totalSpent = Order::where('user_id', $userId)
            ->where('payment_status', 'Paid')
            ->sum('total_price');

        return [
            Stat::make('Cucian Sedang Diproses', $activeOrders)
                ->description('Belum selesai')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),

            Stat::make('Total Transaksi Saya', 'Rp '.number_format($totalSpent, 0, ',', '.'))
                ->description('Total pengeluaran Anda')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
