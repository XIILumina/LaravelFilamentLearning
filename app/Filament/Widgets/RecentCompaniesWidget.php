<?php

namespace App\Filament\Widgets;

use App\Models\Developer;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentCompaniesWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    
    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        return $table
            ->heading('Nesen reģistrētie uzņēmumi')
            ->description('Jaunākie uzņēmumi datu bāzē')
            ->query(
                Developer::query()->latest()->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Reģ. Nr.')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Uzņēmuma nosaukums')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('website')
                    ->label('Tīmekļa vietne')
                    ->url(fn ($record) => $record->website)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-globe-alt')
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('games_count')
                    ->label('Produkti')
                    ->counts('games')
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reģistrācijas datums')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->badge()
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
