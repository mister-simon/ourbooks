<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ShelfInvite extends Pivot
{
    use HasFactory, HasUlids;

    protected $table = 'shelf_invites';

    protected $fillable = [
        'shelf_id',
        'user_id',
        'email',
    ];

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userByMail(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
