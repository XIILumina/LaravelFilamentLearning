<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommunityResource\Pages;
use App\Filament\Resources\CommunityResource\RelationManagers;
use App\Models\Community;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Str;

class CommunityResource extends Resource
{
    protected static ?string $model = Community::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Communities';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                                $set('hashtag', '#' . Str::slug($state, ''));
                            }),
                        
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Community::class, 'slug', ignoreRecord: true)
                            ->rules(['alpha_dash']),
                        
                        Forms\Components\Select::make('game_id')
                            ->relationship('game', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                        
                        Forms\Components\TextInput::make('hashtag')
                            ->required()
                            ->maxLength(255)
                            ->unique(Community::class, 'hashtag', ignoreRecord: true)
                            ->prefix('#')
                            ->placeholder('TF2'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Description & Rules')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->placeholder('Describe what this community is about...'),
                        
                        Forms\Components\Repeater::make('rules')
                            ->schema([
                                Forms\Components\Textarea::make('rule')
                                    ->label('Rule')
                                    ->required()
                                    ->rows(2),
                            ])
                            ->defaultItems(3)
                            ->addActionLabel('Add Rule')
                            ->collapsible(),
                    ]),

                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('banner_image')
                            ->label('Banner Image')
                            ->image()
                            ->directory('community-banners')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('300'),
                        
                        Forms\Components\FileUpload::make('icon_image')
                            ->label('Community Icon')
                            ->image()
                            ->directory('community-icons')
                            ->maxSize(1024)
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('200')
                            ->imageResizeTargetHeight('200')
                            ->avatar(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive communities will not be visible to users'),
                        
                        Forms\Components\TextInput::make('subscriber_count')
                            ->label('Subscriber Count')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->helperText('Automatically updated when users subscribe'),
                        
                        Forms\Components\TextInput::make('post_count')
                            ->label('Post Count')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->helperText('Automatically updated when posts are created'),
                        
                        Forms\Components\DateTimePicker::make('last_post_at')
                            ->label('Last Post At')
                            ->disabled()
                            ->helperText('Automatically updated when new posts are created'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon_image')
                    ->label('Icon')
                    ->circular()
                    ->size(40),
                
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),
                
                Tables\Columns\TextColumn::make('hashtag')
                    ->label('Tag')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('game.title')
                    ->label('Game')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('subscriber_count')
                    ->label('Subscribers')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state)),
                
                Tables\Columns\TextColumn::make('post_count')
                    ->label('Posts')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state)),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                Tables\Columns\TextColumn::make('last_post_at')
                    ->label('Last Post')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->placeholder('No posts yet'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('game')
                    ->relationship('game', 'title')
                    ->searchable()
                    ->preload(),
                
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->native(false),
                
                Tables\Filters\Filter::make('has_posts')
                    ->label('Has Posts')
                    ->query(fn (Builder $query): Builder => $query->where('post_count', '>', 0)),
                
                Tables\Filters\Filter::make('popular')
                    ->label('Popular (10+ subscribers)')
                    ->query(fn (Builder $query): Builder => $query->where('subscriber_count', '>=', 10)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->slideOver(),
                
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                
                Tables\Actions\Action::make('view_posts')
                    ->label('View Posts')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->url(fn (Community $record): string => "/admin/communities/{$record->id}/posts")
                    ->openUrlInNewTab(),
                
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_active' => false])),
                    
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No Communities Yet')
            ->emptyStateDescription('Create your first community to get started!')
            ->emptyStateIcon('heroicon-o-user-group');
    }

    public static function getRelations(): array
    {
        return [
            CommunityResource\RelationManagers\PostsRelationManager::class,
            CommunityResource\RelationManagers\SubscribersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommunities::route('/'),
            'create' => Pages\CreateCommunity::route('/create'),
            'edit' => Pages\EditCommunity::route('/{record}/edit'),
        ];
    }
}
