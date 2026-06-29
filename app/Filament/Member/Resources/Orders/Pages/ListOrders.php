<?php

namespace App\Filament\Member\Resources\Orders\Pages;

use App\Filament\Member\Resources\Orders\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
}
