<?php

namespace App\Notifications;

use App\Models\ShelfInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitedToShelf extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public ShelfInvite $shelfInvite
    ) {
    }

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
        $friendName = $this
            ->shelfInvite
            ?->invitedBy
            ?->name
            ?? __('Your friend');

        $shelfName = $this->shelfInvite
            ->shelf
            ->title;

        $subject = __(
            ':username has invited to their bookshelf ":shelf"',
            [
                'username' => $friendName,
                'shelf' => $shelfName,
            ]
        );

        $greeting = __(
            'Hi :name',
            ['name' => $notifiable->name ?? $this->shelfInvite->name]
        );

        return (new MailMessage)
            ->subject($subject)
            ->tag('invitation')
            ->greeting($greeting)
            ->line($subject)
            ->lineIf(! $this->shelfInvite->user, 'You don\'t yet have an account yet, but you can sign up to join in.')
            ->action('Accept Invitation', route('shelves.show', ['shelf' => $this->shelfInvite->shelf_id]))
            ->line('If you don\'t want to join feel free to ignore this email.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return ['invite_id' => $this->shelfInvite->id];
    }
}
