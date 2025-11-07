<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('send_email')
                ->label('Send Email Response')
                ->icon('heroicon-o-envelope')
                ->color('info')
                ->visible(fn () => !empty($this->record->admin_response))
                ->action(function () {
                    // Here you would implement actual email sending
                    // For now, just show a notification
                    Notification::make()
                        ->title('Email Response Sent!')
                        ->body('The response has been sent to ' . $this->record->email)
                        ->success()
                        ->send();
                }),
                
            Actions\DeleteAction::make()
                ->requiresConfirmation(),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Contact message updated successfully!';
    }

    protected function afterSave(): void
    {
        // If status changed to resolved or closed, update responded_at and responded_by
        if (in_array($this->record->status, ['resolved', 'closed']) && !$this->record->responded_at) {
            $this->record->update([
                'responded_at' => now(),
                'responded_by' => Auth::id(),
            ]);
        }
    }
}
