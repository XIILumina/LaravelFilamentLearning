<?php

namespace App\Filament\Resources;

use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $slug = 'attributes';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'PIM';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Attribute Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('input_type')
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'select' => 'Select Dropdown',
                                'multiselect' => 'Multi-select',
                                'checkbox' => 'Checkbox',
                                'date' => 'Date',
                                'file' => 'File',
                                'number' => 'Number',
                                'color' => 'Color Picker',
                            ])
                            ->default('text')
                            ->required(),
                        Forms\Components\Select::make('field_type')
                            ->options([
                                'text' => 'Text',
                                'number' => 'Number',
                                'boolean' => 'Boolean',
                                'date' => 'Date',
                                'url' => 'URL',
                                'email' => 'Email',
                            ])
                            ->default('text')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Configuration')
                    ->schema([
                        Forms\Components\Toggle::make('is_filterable')
                            ->default(true),
                        Forms\Components\Toggle::make('is_searchable')
                            ->default(false),
                        Forms\Components\Toggle::make('is_required')
                            ->default(false),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\KeyValue::make('options')
                            ->keyLabel('Option Key')
                            ->valueLabel('Option Value')
                            ->columnSpanFull()
                            ->helperText('Add options for select/multiselect inputs'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('input_type')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_filterable')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_searchable')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_required')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_filterable'),
                Tables\Filters\TernaryFilter::make('is_searchable'),
                Tables\Filters\TernaryFilter::make('is_required'),
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
            'index' => \App\Filament\Resources\AttributeResource\Pages\ListAttributes::route('/'),
            'create' => \App\Filament\Resources\AttributeResource\Pages\CreateAttribute::route('/create'),
            'edit' => \App\Filament\Resources\AttributeResource\Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
