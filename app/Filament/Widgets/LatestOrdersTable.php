<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrdersTable extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Pesanan Menunggu Konfirmasi';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::where('laundry_status', 'Pending Confirmation')
                    ->latest('order_date')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Nota')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Pelanggan'),
                TextColumn::make('order_date')
                    ->label('Tanggal')
                    ->dateTime(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.view', $record)),
                EditAction::make()
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.edit', $record)),
            ]);
    }
}
