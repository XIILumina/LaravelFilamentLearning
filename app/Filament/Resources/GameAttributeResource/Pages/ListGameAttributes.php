<?php

namespace App\Filament\Resources\GameAttributeResource\Pages;

use App\Filament\Resources\GameAttributeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGameAttributes extends ListRecords
{
    protected static string $resource = GameAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
