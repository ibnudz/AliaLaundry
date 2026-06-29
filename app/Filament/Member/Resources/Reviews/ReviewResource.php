<?php

namespace App\Filament\Member\Resources\Reviews;

use App\Filament\Member\Resources\Reviews\Pages\CreateReview;
use App\Filament\Member\Resources\Reviews\Pages\ListReviews;
use App\Filament\Member\Resources\Reviews\Pages\ViewReview;
use App\Filament\Member\Resources\Reviews\Schemas\ReviewInfolist;
use App\Filament\Member\Resources\Reviews\Tables\ReviewsTable;
use App\Models\Order;
use App\Models\Review;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    public static function form(Schema $schema): Schema
    {
        // return ReviewForm::configure($schema);
        return $schema
            ->schema([
                Hidden::make('user_id')
                    ->default(Auth::id()),

                Select::make('order_id')
                    ->label('Nomor Nota (Pesanan)')
                    ->options(function () {
                        return Order::where('user_id', Auth::id())
                            ->whereIn('laundry_status', ['Completed', 'Picked Up'])
                            ->pluck('invoice_number', 'id');
                    })
                    ->required(),

                Select::make('rating')
                    ->label('Bintang / Penilaian')
                    ->options([
                        1 => '⭐ 1 - Sangat Buruk',
                        2 => '⭐⭐ 2 - Buruk',
                        3 => '⭐⭐⭐ 3 - Cukup',
                        4 => '⭐⭐⭐⭐ 4 - Baik',
                        5 => '⭐⭐⭐⭐⭐ 5 - Sangat Baik',
                    ])
                    ->required(),

                Textarea::make('comment')
                    ->label('Ulasan Anda')
                    ->rows(3),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReviewInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        // return ReviewsTable::configure($table);
        return $table
            ->columns([
                TextColumn::make('order.invoice_number')->label('Nota'),
                TextColumn::make('rating')->label('Rating')
                    ->formatStateUsing(fn (string $state): string => str_repeat('⭐', (int) $state)),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                ViewAction::make(),
            ]);
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
            'index' => ListReviews::route('/'),
            'create' => CreateReview::route('/create'),
            'view' => ViewReview::route('/{record}'),
        ];
    }
}
