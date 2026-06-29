<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! isset($data['invoice_number'])) {
            $data['invoice_number'] = 'INV-ALIA-'.strtoupper(Str::random(3)).now()->format('YmdHis');
        }

        return $data;
    }
}
