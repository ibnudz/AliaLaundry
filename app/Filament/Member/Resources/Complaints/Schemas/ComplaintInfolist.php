<?php

namespace App\Filament\Member\Resources\Complaints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('order.invoice_number')
                    ->label('Nota'),
                TextEntry::make('issue_description')
                    ->label('Keluhan')
                    ->columnSpanFull(),
                TextEntry::make('complaint_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'danger',
                        'Processing' => 'warning',
                        'Resolved' => 'success',
                        default => 'gray',
                    }),
                TextEntry::make('resolution')
                    ->label('Solusi')
                    ->placeholder('Belum ada solusi')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
