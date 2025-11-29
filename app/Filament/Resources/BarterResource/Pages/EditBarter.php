<?php

namespace App\Filament\Resources\BarterResource\Pages;

use App\Filament\Resources\BarterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBarter extends EditRecord
{
    protected static string $resource = BarterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
