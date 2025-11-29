<?php

namespace App\Filament\Resources\UserWantResource\Pages;

use App\Filament\Resources\UserWantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserWants extends ListRecords
{
    protected static string $resource = UserWantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
