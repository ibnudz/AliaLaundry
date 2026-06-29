<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('order.invoice_number')
                    ->label('Nota')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Pelanggan')
                    ->searchable(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn (string $state): string => str_repeat('⭐', (int) $state))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('rating')
                    ->options([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5]),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
