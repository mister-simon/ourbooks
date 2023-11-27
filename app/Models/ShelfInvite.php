<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShelfInvite extends Model
{
    use HasFactory;

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
