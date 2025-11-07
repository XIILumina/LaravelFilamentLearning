<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Facades\Auth;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static ?string $navigationGroup = 'Support';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $pendingCount = static::getModel()::where('status', 'pending')->count();
        
        if ($pendingCount > 10) {
            return 'danger';
        } elseif ($pendingCount > 5) {
            return 'warning';
        } elseif ($pendingCount > 0) {
            return 'info';
        }
        
        return null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->maxLength(255)
                            ->disabled(),
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->rows(5)
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Response & Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'resolved' => 'Resolved',
                                'closed' => 'Closed',
                            ])
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, $record) {
                                if ($state === 'resolved' || $state === 'closed') {
                                    $record?->update([
                                        'responded_at' => now(),
                                        'responded_by' => Auth::id(),
                                    ]);
                                }
                            }),
                        
                        Forms\Components\Textarea::make('admin_response')
                            ->label('Admin Response')
                            ->placeholder('Write your response to the customer...')
                            ->rows(5)
                            ->visible(fn ($get) => in_array($get('status'), ['in_progress', 'resolved', 'closed'])),
                            
                        Forms\Components\DateTimePicker::make('responded_at')
                            ->label('Response Date')
                            ->disabled(),
                            
                        Forms\Components\Select::make('responded_by')
                            ->label('Responded By')
                            ->relationship('respondedBy', 'name')
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),
                    
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                    
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function ($record) {
                        return $record->subject;
                    }),
                    
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->message;
                    })
                    ->wrap(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'in_progress',
                        'success' => 'resolved',
                        'secondary' => 'closed',
                    ])
                    ->icons([
                        'pending' => 'heroicon-o-clock',
                        'in_progress' => 'heroicon-o-arrow-path',
                        'resolved' => 'heroicon-o-check-circle',
                        'closed' => 'heroicon-o-x-circle',
                    ]),
                    
                Tables\Columns\TextColumn::make('respondedBy.name')
                    ->label('Responded By')
                    ->placeholder('—')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                    
                Tables\Columns\TextColumn::make('responded_at')
                    ->label('Responded')
                    ->dateTime()
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'resolved' => 'Resolved',
                        'closed' => 'Closed',
                    ])
                    ->multiple(),
                    
                Tables\Filters\Filter::make('unresponded')
                    ->label('Unresponded')
                    ->query(fn (Builder $query): Builder => $query->whereNull('responded_at')),
                    
                Tables\Filters\Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today())),
                    
                Tables\Filters\Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn (Builder $query): Builder => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->slideOver(),
                    
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                    
                Tables\Actions\Action::make('quick_respond')
                    ->label('Quick Response')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('info')
                    ->form([
                        Forms\Components\Textarea::make('response')
                            ->label('Response')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'admin_response' => $data['response'],
                            'status' => 'resolved',
                            'responded_at' => now(),
                            'responded_by' => Auth::id(),
                        ]);
                        
                        Notification::make()
                            ->title('Response sent successfully!')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => $record->status === 'pending'),
                    
                Tables\Actions\Action::make('mark_resolved')
                    ->label('Mark Resolved')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'resolved',
                            'responded_at' => now(),
                            'responded_by' => Auth::id(),
                        ]);
                        
                        Notification::make()
                            ->title('Marked as resolved!')
                            ->success()
                            ->send();
                    })
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'in_progress'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('mark_resolved')
                        ->label('Mark as Resolved')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'resolved',
                                    'responded_at' => now(),
                                    'responded_by' => Auth::id(),
                                ]);
                            });
                            
                            Notification::make()
                                ->title('Selected messages marked as resolved!')
                                ->success()
                                ->send();
                        }),
                        
                    Tables\Actions\BulkAction::make('mark_closed')
                        ->label('Mark as Closed')
                        ->icon('heroicon-o-x-circle')
                        ->color('gray')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'closed',
                                    'responded_at' => now(),
                                    'responded_by' => Auth::id(),
                                ]);
                            });
                            
                            Notification::make()
                                ->title('Selected messages marked as closed!')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto-refresh every 30 seconds
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ContactResource\Widgets\ContactStatsWidget::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
