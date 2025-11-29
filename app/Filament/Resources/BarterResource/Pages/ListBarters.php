<?php

namespace App\Filament\Resources\BarterResource\Pages;

use App\Filament\Resources\BarterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBarters extends ListRecords
{
    protected static string $resource = BarterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
