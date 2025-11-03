<?php

namespace App\Filament\Resources\AppObjectResource\Pages;

use App\Filament\Resources\AppObjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppObject extends EditRecord
{
    protected static string $resource = AppObjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
