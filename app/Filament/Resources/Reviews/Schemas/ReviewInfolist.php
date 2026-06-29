<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('order.invoice_number')
                    ->label('Nota'),
                TextEntry::make('user.name')
                    ->label('Pelanggan'),
                TextEntry::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn (int $state): string => str_repeat('⭐', $state)),
                TextEntry::make('comment')
                    ->label('Komentar')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
