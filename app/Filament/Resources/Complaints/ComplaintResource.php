<?php

namespace App\Filament\Resources\Complaints;

use App\Filament\Resources\Complaints\Pages\ListComplaints;
use App\Filament\Resources\Complaints\Pages\ViewComplaint;
use App\Filament\Resources\Complaints\Schemas\ComplaintInfolist;
use App\Filament\Resources\Complaints\Tables\ComplaintsTable;
use App\Models\Complaint;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    public static function form(Schema $schema): Schema
    {
        // return ComplaintForm::configure($schema);
        return $schema
            ->schema([
                // Bagian 1: Informasi komplain dari user (Read-Only)
                Section::make('Detail Komplain Pelanggan')
                    ->schema([
                        TextInput::make('order.invoice_number')
                            ->label('Nomor Nota')
                            ->disabled(),

                        TextInput::make('user.name')
                            ->label('Nama Pelanggan')
                            ->disabled(),

                        Textarea::make('issue_description')
                            ->label('Keluhan')
                            ->columnSpanFull()
                            ->disabled(),
                    ])->columns(2),

                // Bagian 2: Area eksekusi Admin
                Section::make('Tindakan Penyelesaian')
                    ->schema([
                        Select::make('complaint_status')
                            ->label('Status Penanganan')
                            ->options([
                                'Pending' => 'Pending (Menunggu)',
                                'Processing' => 'Processing (Sedang Ditangani)',
                                'Resolved' => 'Resolved (Selesai)',
                            ])
                            ->required(),

                        Textarea::make('resolution')
                            ->label('Solusi / Catatan Penyelesaian')
                            ->helperText('Berikan penjelasan solusi atau kompensasi kepada pelanggan.')
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(1),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ComplaintInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComplaintsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComplaints::route('/'),
            'view' => ViewComplaint::route('/{record}'),
        ];
    }
}
