<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Models\Game;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Games';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(4),

                Forms\Components\DatePicker::make('release_date')
                    ->label('Release date'),

                // Publisher as plain text input (you might prefer relationship)
                Forms\Components\TextInput::make('publisher')
                    ->label('Publisher')
                    ->maxLength(255),

                Forms\Components\TextInput::make('rating')
                    ->label('Rating (0–10)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->step(0.1)
                    ->required(),

                // File upload for image (stores path in image_url)
                Forms\Components\FileUpload::make('image_url')
                    ->label('Game Cover')
                    ->image()
                    ->directory('games')
                    ->preserveFilenames(), // optional

                Forms\Components\Toggle::make('featured')
                    ->label('Featured'),

                // Relationship selects
                Forms\Components\Select::make('developer_id')
                    ->label('Developer')
                    ->relationship('developer', 'name')
                    ->searchable()
                    ->preload(),

                // Use Select::multiple for many-to-many (preferred over deprecated MultiSelect)
                Forms\Components\Select::make('genres')
                    ->label('Genres')
                    ->relationship('genres', 'name')
                    ->multiple()
                    ->preload(),

                Forms\Components\Select::make('platforms')
                    ->label('Platforms')
                    ->relationship('platforms', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Title'),

                Tables\Columns\TextColumn::make('developer.name')
                    ->label('Developer')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state !== null ? number_format($state, 1).'/10' : '-'),

                Tables\Columns\IconColumn::make('featured')
                    ->boolean()
                    ->label('Featured'),

                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Cover')
                    ->disk('public') // ensure this disk exists
                    ->rounded(),

                // display comma-separated genres
                Tables\Columns\TextColumn::make('genres')
                    ->label('Genres')
                    ->formatStateUsing(fn ($state, $record) => $record->genres->pluck('name')->join(', '))
                    ->wrap(),

                Tables\Columns\TextColumn::make('platforms')
                    ->label('Platforms')
                    ->formatStateUsing(fn ($state, $record) => $record->platforms->pluck('name')->join(', '))
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\GameResource\RelationManagers\AttributesRelationManager::class,
            \App\Filament\Resources\GameResource\RelationManagers\SkusRelationManager::class,
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
