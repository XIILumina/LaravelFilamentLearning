<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\form;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextArea::make('description')->required(),
                Forms\Components\DatePicker::make('release_date')->required(),
                Forms\Components\Select::make('publisher')->required(),
                Forms\Components\TextInput::make('rating')->required(),
                Forms\Components\TextInput::make('image_url')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')            
                            ->required()
                            ->maxLength(255),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('release_date'),
                Tables\Columns\TextColumn::make('publisher'),
                Tables\Columns\TextColumn::make('rating')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(10)
                            ->step(0.1)
                            ->default(0)
                            ->required()
                            ->label('Rating (0–10)'),
                Tables\Columns\TextColumn::make('image_url')            
                        ->label('Game Cover')
                        ->directory('games'),
                                Forms\Components\Toggle::make('featured'),

        Forms\Components\Select::make('developer_id')
            ->relationship('developer', 'name')
            ->label('Developer'),

        Forms\Components\MultiSelect::make('genres')
            ->relationship('genres', 'name')
            ->label('Genres'),

        Forms\Components\MultiSelect::make('platforms')
            ->relationship('platforms', 'name')
            ->label('Platforms'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}