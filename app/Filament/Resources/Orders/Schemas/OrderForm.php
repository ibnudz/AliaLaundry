<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                DateTimePicker::make('order_date')
                    ->required(),
                DatePicker::make('estimated_finish_at'),
                Select::make('laundry_status')
                    ->options([
                        'Pending Confirmation' => 'Pending confirmation',
                        'Queued' => 'Queued',
                        'Washing' => 'Washing',
                        'Ironing' => 'Ironing',
                        'Completed' => 'Completed',
                        'Picked Up' => 'Picked up',
                    ])
                    ->default('Pending Confirmation')
                    ->required(),
                Select::make('payment_status')
                    ->options(['Unpaid' => 'Unpaid', 'Paid' => 'Paid'])
                    ->default('Unpaid')
                    ->required(),
                Textarea::make('customer_note')
                    ->columnSpanFull(),
                Repeater::make('orderDetails')
                    ->relationship()
                    ->schema([
                        Select::make('service_id')
                            ->relationship('service', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if (! $state) {
                                    return;
                                }
                                $service = Service::find($state);
                                if ($service) {
                                    $qty = (float) ($get('quantity') ?: 1);
                                    $set('price', $service->price * $qty);
                                }
                            })
                            ->required(),
                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->live()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $serviceId = $get('service_id');
                                if (! $serviceId) {
                                    return;
                                }
                                $service = Service::find($serviceId);
                                if ($service) {
                                    $qty = (float) ($get('quantity') ?: 1);
                                    $set('price', $service->price * $qty);
                                }
                            })
                            ->required(),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->required(),
                    ])
                    ->columns(3)
                    ->addActionLabel('Tambah Layanan')
                    ->defaultItems(1)
                    ->minItems(1),
            ]);
    }
}
