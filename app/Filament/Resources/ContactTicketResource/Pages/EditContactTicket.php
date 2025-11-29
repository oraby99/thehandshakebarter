<?php

namespace App\Filament\Resources\ContactTicketResource\Pages;

use App\Filament\Resources\ContactTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactTicket extends EditRecord
{
    protected static string $resource = ContactTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
