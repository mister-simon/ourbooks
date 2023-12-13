<?php

namespace App\Models;

use App\Enums\ReadStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookUser extends Pivot
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'book_id',
        'user_id',
        'read',
        'rating',
        'comments',
    ];

    protected $casts = [
        'read' => ReadStatus::class,
    ];

    public function getReadOrUnknownAttribute()
    {
        return $this->read ?? ReadStatus::UNKNOWN;
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
