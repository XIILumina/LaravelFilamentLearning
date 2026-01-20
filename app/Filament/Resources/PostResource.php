<?php

namespace App\Filament\Resources;

use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Post Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->directory('posts'),
                    ]),
                Forms\Components\Section::make('Relationships')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('game_id')
                            ->relationship('game', 'title')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('community_id')
                            ->relationship('community', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(3),
                Forms\Components\Section::make('Stats & Status')
                    ->schema([
                        Forms\Components\TextInput::make('likes_count')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('dislikes_count')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('comments_count')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_pinned')
                            ->default(false),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('community.name')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('game.title')
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('likes_count')
                    ->sortable()
                    ->label('Likes'),
                Tables\Columns\TextColumn::make('dislikes_count')
                    ->sortable()
                    ->label('Dislikes'),
                Tables\Columns\TextColumn::make('comments_count')
                    ->sortable()
                    ->label('Comments'),
                Tables\Columns\IconColumn::make('is_pinned')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('community')
                    ->relationship('community', 'name'),
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name'),
                Tables\Filters\TernaryFilter::make('is_pinned'),
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

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\PostResource\Pages\ListPosts::route('/'),
            'create' => \App\Filament\Resources\PostResource\Pages\CreatePost::route('/create'),
            'edit' => \App\Filament\Resources\PostResource\Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
