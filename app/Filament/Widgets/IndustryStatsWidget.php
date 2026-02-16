<?php

namespace App\Filament\Widgets;

use App\Models\Genre;
use App\Models\Platform;
use App\Models\Post;
use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IndustryStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Industriju kategorijas', Genre::count())
                ->description('Reģistrēto kategoriju skaits')
                ->descriptionIcon('heroicon-o-tag')
                ->color('primary'),
            
            Stat::make('Platformas', Platform::count())
                ->description('Pieejamās platformas')
                ->descriptionIcon('heroicon-o-server-stack')
                ->color('success'),
            
            Stat::make('Publikācijas', Post::count())
                ->description('Kopējais publikāciju skaits')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('warning'),
            
            Stat::make('Kontaktu pieprasījumi', Contact::count())
                ->description('Saņemtie pieprasījumi')
                ->descriptionIcon('heroicon-o-envelope')
                ->color('danger'),
        ];
    }
    
    protected function getColumns(): int
    {
        return 4;
    }
}
