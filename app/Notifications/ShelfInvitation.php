<?php

namespace App\Notifications;

use App\Models\Shelf;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ShelfInvitation extends Notification
{
    use Queueable;

    public function __construct(
        public Shelf $shelf,
        public User $user
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = URL::signedRoute('auth.login', ['user' => $notifiable, 'shelf' => $this->shelf->id]);

        $name = config('app.name');

        return (new MailMessage)
            ->success()
            ->subject("{$name} - Shelf Invitation from '{$this->user->name}' - Shelf '{$this->shelf->title}'")
            ->line("You've been invited by '{$this->user->name}' to share their shelf '{$this->shelf->title}'.")
            ->line("Click the link below to accept the invitation, or ignore this email if you'd rather not.")
            ->action('Accept Shelf Invite', $url)
            ->line('Thanks!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
