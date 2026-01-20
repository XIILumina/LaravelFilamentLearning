<?php

namespace App\Filament\Resources;

use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Comment Information')
                    ->schema([
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('post_id')
                            ->relationship('post', 'title')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'content')
                            ->label('Parent Comment (for replies)')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
                Forms\Components\Section::make('Stats')
                    ->schema([
                        Forms\Components\TextInput::make('likes_count')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('dislikes_count')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('content')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('post.title')
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('likes_count')
                    ->sortable()
                    ->label('Likes'),
                Tables\Columns\TextColumn::make('dislikes_count')
                    ->sortable()
                    ->label('Dislikes'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name'),
                Tables\Filters\SelectFilter::make('post')
                    ->relationship('post', 'title'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\CommentResource\Pages\ListComments::route('/'),
            'create' => \App\Filament\Resources\CommentResource\Pages\CreateComment::route('/create'),
            'edit' => \App\Filament\Resources\CommentResource\Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
