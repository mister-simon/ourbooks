<?php

namespace App\Models;

use App\Notifications\InvitedToShelf;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Notification;

class ShelfInvite extends Pivot
{
    use HasFactory, HasUlids;

    protected $table = 'shelf_invites';

    protected $fillable = [
        'shelf_id',
        'user_id',
        'invited_by_id',
        'email',
        'name',
    ];

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userByEmail(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function getNotifiable()
    {
        if ($this->user?->exists) {
            return $this->user;
        }

        return [$this->email => $this->name];
    }

    /**
     * Send the invitation to an existing user
     *  or send it to an anonymous email recipient.
     */
    public function notifyUser()
    {
        $invite = new InvitedToShelf($this);

        if ($this->user?->exists) {
            return $this->user->notify($invite);
        }

        Notification::route('mail', [
            $this->email => $this->name,
        ])->notify($invite);
    }

    public function confirm()
    {
        $this->shelf
            ->users()
            ->syncWithoutDetaching($this->user);
    }
}
