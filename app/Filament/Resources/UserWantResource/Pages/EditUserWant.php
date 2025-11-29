<?php

namespace App\Filament\Resources\UserWantResource\Pages;

use App\Filament\Resources\UserWantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserWant extends EditRecord
{
    protected static string $resource = UserWantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
