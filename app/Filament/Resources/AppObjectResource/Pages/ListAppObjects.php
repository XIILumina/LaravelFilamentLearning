<?php

namespace App\Filament\Resources\AppObjectResource\Pages;

use App\Filament\Resources\AppObjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppObjects extends ListRecords
{
    protected static string $resource = AppObjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
