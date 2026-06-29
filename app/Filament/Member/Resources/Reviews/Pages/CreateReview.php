<?php

namespace App\Filament\Member\Resources\Reviews\Pages;

use App\Filament\Member\Resources\Reviews\ReviewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReview extends CreateRecord
{
    protected static string $resource = ReviewResource::class;
}
