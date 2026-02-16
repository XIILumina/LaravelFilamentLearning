<?php

namespace App\Filament\Widgets;

use App\Models\Developer;
use App\Models\Game;
use App\Models\Genre;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class DataCatalogChart extends ChartWidget
{
    protected static ?string $heading = 'Datu kataloga izaugsme';
    
    protected static ?int $sort = 2;
    
    protected static ?string $description = 'Reģistrēto vienību skaita izmaiņas pēdējo 7 mēnešu laikā';

    protected function getData(): array
    {
        // Simulate monthly growth data
        return [
            'datasets' => [
                [
                    'label' => 'Uzņēmumi',
                    'data' => [45, 52, 61, 68, 74, 82, Developer::count()],
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
                [
                    'label' => 'Produkti',
                    'data' => [120, 135, 148, 162, 178, 195, Game::count()],
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                ],
                [
                    'label' => 'Lietotāji',
                    'data' => [230, 267, 312, 359, 402, 445, User::count()],
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                ],
            ],
            'labels' => ['Aug', 'Sep', 'Okt', 'Nov', 'Dec', 'Jan', 'Feb'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}
