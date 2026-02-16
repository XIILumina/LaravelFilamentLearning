<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use App\Models\Genre;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopCategoriesWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        return $table
            ->heading('Populārākās kategorijas')
            ->description('TOP 10 kategorijas pēc produktu skaita')
            ->query(
                Genre::query()
                    ->withCount('games')
                    ->orderBy('games_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Kategorijas nosaukums')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-tag')
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('games_count')
                    ->label('Produktu skaits')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state > 20 => 'success',
                        $state > 10 => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Izveidots')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('games_count', 'desc')
            ->paginated(false);
    }
}
