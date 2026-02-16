<?php

namespace App\Filament\Widgets;

use App\Models\Developer;
use App\Models\User;
use App\Models\Game;
use App\Models\Community;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RegisteredEntitiesWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Reģistrētie uzņēmumi', Developer::count())
                ->description('Kopējais reģistrēto uzņēmumu skaits')
                ->descriptionIcon('heroicon-o-building-office-2')
                ->color('primary')
                ->chart([7, 12, 15, 19, 23, 25, 28]),
            
            Stat::make('Aktīvie lietotāji', User::where('role', '!=', 'admin')->count())
                ->description('Reģistrētie lietotāji sistēmā')
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([45, 52, 60, 71, 78, 82, 89]),
            
            Stat::make('Publicētie produkti', Game::count())
                ->description('Kopējais produktu skaits')
                ->descriptionIcon('heroicon-o-cube')
                ->color('warning')
                ->chart([30, 35, 42, 48, 51, 58, 62]),
            
            Stat::make('Aktīvās kopienas', Community::count())
                ->description('Reģistrētās kopienas')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info')
                ->chart([5, 8, 12, 15, 18, 21, 24]),
        ];
    }
    
    protected function getColumns(): int
    {
        return 4;
    }
}
