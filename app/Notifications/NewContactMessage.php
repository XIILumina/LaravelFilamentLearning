<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Contact $contact
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Contact Message: {$this->contact->subject}")
            ->greeting('New Contact Message Received!')
            ->line("From: {$this->contact->name} ({$this->contact->email})")
            ->line("Subject: {$this->contact->subject}")
            ->line("Message:")
            ->line($this->contact->message)
            ->action('View in Admin Panel', route('filament.admin.resources.contacts.edit', $this->contact))
            ->line('Please respond to this message as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'contact_id' => $this->contact->id,
            'contact_name' => $this->contact->name,
            'contact_email' => $this->contact->email,
            'contact_subject' => $this->contact->subject,
            'message' => "New contact message from {$this->contact->name}",
        ];
    }
}
