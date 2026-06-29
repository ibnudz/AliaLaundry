<?php

namespace App\Filament\Member\Widgets;

use App\Models\Order;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class ActiveTrackerTable extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Pesanan Terakhir';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::where('user_id', Auth::id())
                    ->latest('order_date')
                    ->limit(3)
            )
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Nota')
                    ->searchable(),
                TextColumn::make('order_date')
                    ->label('Tanggal')
                    ->dateTime(),
                TextColumn::make('laundry_status')
                    ->label('Status Cucian')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending Confirmation' => 'warning',
                        'Queued' => 'info',
                        'Washing' => 'purple',
                        'Ironing' => 'orange',
                        'Completed' => 'success',
                        'Picked Up' => 'gray',
                    }),
                TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Unpaid' => 'danger',
                        'Paid' => 'success',
                    }),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),
            ])
            ->actions([
                ViewAction::make()
                    ->url(fn (Order $record): string => route('filament.member.resources.orders.view', $record)),
            ]);
    }
}
