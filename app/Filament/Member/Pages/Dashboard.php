<?php

namespace App\Filament\Member\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string
    {
        return 'Halo, '.(auth()->user()->name ?? 'Pengguna').'!';
    }

    public function getSubheading(): ?string
    {
        return 'Ada cucian kotor hari ini?';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('buatPesanan')
                ->label('Buat Pesanan Baru')
                ->url(BuatPesanan::getUrl())
                ->size('xl')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
