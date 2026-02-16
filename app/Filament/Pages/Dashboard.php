<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.pages.dashboard';
    
    protected static ?string $title = 'Datu Portāls - Uzņēmumu Reģistrs';
    
    protected static ?string $navigationLabel = 'Galvenā';
}
