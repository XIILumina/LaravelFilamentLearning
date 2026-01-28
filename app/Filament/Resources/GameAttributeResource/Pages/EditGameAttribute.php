<?php

namespace App\Filament\Resources\GameAttributeResource\Pages;

use App\Filament\Resources\GameAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGameAttribute extends EditRecord
{
    protected static string $resource = GameAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
