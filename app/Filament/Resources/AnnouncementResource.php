<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Filament\Resources\AnnouncementResource\RelationManagers;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Announcement Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'general' => 'General',
                                'update' => 'Update',
                                'maintenance' => 'Maintenance',
                                'event' => 'Event',
                            ])
                            ->default('general'),
                    ]),
                Forms\Components\Section::make('Publishing Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Toggle to show/hide this announcement'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->helperText('Leave empty to publish immediately'),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->helperText('Leave empty for no expiration'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'general',
                        'info' => 'update',
                        'warning' => 'maintenance',
                        'success' => 'event',
                    ])
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Created By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'general' => 'General',
                        'update' => 'Update',
                        'maintenance' => 'Maintenance',
                        'event' => 'Event',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
