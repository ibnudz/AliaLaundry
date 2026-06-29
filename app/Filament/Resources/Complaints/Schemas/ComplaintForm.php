<?php

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Textarea::make('issue_description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('complaint_status')
                    ->options(['Pending' => 'Pending', 'Processing' => 'Processing', 'Resolved' => 'Resolved'])
                    ->default('Pending')
                    ->required(),
                Textarea::make('resolution')
                    ->columnSpanFull(),
            ]);
    }
}
