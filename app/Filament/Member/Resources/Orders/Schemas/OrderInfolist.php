<?php

namespace App\Filament\Member\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('invoice_number'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('order_date')
                    ->dateTime(),
                TextEntry::make('estimated_finish_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('laundry_status')
                    ->badge(),
                TextEntry::make('payment_status')
                    ->badge(),
                TextEntry::make('total_price')
                    ->money('IDR'),
                TextEntry::make('customer_note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                RepeatableEntry::make('orderDetails')
                    ->label('Layanan')
                    ->table([
                        TableColumn::make('Layanan'),
                        TableColumn::make('Quantity'),
                        TableColumn::make('Harga'),
                    ])
                    ->schema([
                        TextEntry::make('service.name'),
                        TextEntry::make('quantity'),
                        TextEntry::make('price')
                            ->money('IDR'),
                    ])
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
