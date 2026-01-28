<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameAttributeResource\Pages;
use App\Models\GameAttribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GameAttributeResource extends Resource
{
    protected static ?string $model = GameAttribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Game Attributes';
    protected static ?string $navigationGroup = 'PIM';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('game_id')
                    ->label('Game')
                    ->relationship('game', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                Forms\Components\Select::make('attribute_id')
                    ->label('Attribute')
                    ->relationship('attribute', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', '')),
                    
                Forms\Components\TextInput::make('value')
                    ->label('Value')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('game.title')
                    ->label('Game')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('attribute.name')
                    ->label('Attribute')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGameAttributes::route('/'),
            'create' => Pages\CreateGameAttribute::route('/create'),
            'edit' => Pages\EditGameAttribute::route('/{record}/edit'),
        ];
    }
}
