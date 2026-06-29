<?php

namespace App\Filament\Member\Resources\Complaints;

use App\Filament\Member\Resources\Complaints\Pages\CreateComplaint;
use App\Filament\Member\Resources\Complaints\Pages\ListComplaints;
use App\Filament\Member\Resources\Complaints\Pages\ViewComplaint;
use App\Filament\Member\Resources\Complaints\Schemas\ComplaintInfolist;
use App\Filament\Member\Resources\Complaints\Tables\ComplaintsTable;
use App\Models\Complaint;
use App\Models\Order;
use BackedEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    public static function form(Schema $schema): Schema
    {
        // return ComplaintForm::configure($schema);
        return $schema
            ->schema([
                Hidden::make('user_id')
                    ->default(Auth::id()),

                Select::make('order_id')
                    ->label('Nomor Nota Bermasalah')
                    ->options(function () {
                        return Order::where('user_id', Auth::id())
                            ->pluck('invoice_number', 'id');
                    })
                    ->required(),

                Textarea::make('issue_description')
                    ->label('Jelaskan Keluhan Anda')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComplaints::route('/'),
            'create' => CreateComplaint::route('/create'),
            'view' => ViewComplaint::route('/{record}'),
        ];
    }
}
