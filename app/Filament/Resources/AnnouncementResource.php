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
                Forms\Components\Section::make('Quick Templates')
                    ->description('Click a template to auto-fill the form')
                    ->schema([
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('template_new_feature')
                                ->label('🎉 New Feature')
                                ->action(function ($set) {
                                    $set('title', 'New Feature: [Feature Name]');
                                    $set('content', "We're excited to announce a new feature! [Describe the feature and how to use it]. Try it out now!");
                                    $set('type', 'update');
                                }),
                            Forms\Components\Actions\Action::make('template_maintenance')
                                ->label('🔧 Maintenance')
                                ->action(function ($set) {
                                    $set('title', 'Scheduled Maintenance');
                                    $set('content', "We'll be performing scheduled maintenance on [Date] at [Time]. Expected downtime: [Duration]. Thank you for your patience!");
                                    $set('type', 'maintenance');
                                }),
                            Forms\Components\Actions\Action::make('template_event')
                                ->label('🎮 Event')
                                ->action(function ($set) {
                                    $set('title', '[Event Name] - Join Us!');
                                    $set('content', "Don't miss out on our [Event Name]! Starting [Date] at [Time]. [Event details and rewards]. See you there!");
                                    $set('type', 'event');
                                }),
                            Forms\Components\Actions\Action::make('template_community')
                                ->label('💬 Community Update')
                                ->action(function ($set) {
                                    $set('title', 'Community Update');
                                    $set('content', "Hello gamers! [Share community news, achievements, or upcoming changes]. Thanks for being part of our community!");
                                    $set('type', 'general');
                                }),
                        ])
                            ->columnSpanFull(),
                    ])
                    ->collapsed(false),
                Forms\Components\Section::make('Announcement Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('e.g., "New Games Added This Week!"'),
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull()
                            ->placeholder('Write your announcement message here...'),
                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                'general' => '📢 General',
                                'update' => '🔔 Update',
                                'maintenance' => '🔧 Maintenance',
                                'event' => '🎉 Event',
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
                            ->helperText('Leave empty to publish immediately')
                            ->native(false),
                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Expiration Date')
                            ->helperText('Leave empty for no expiration')
                            ->native(false),
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
