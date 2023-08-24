<?php

namespace App\Models;

use App\Enums\ReadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BookUser extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'user_id',
        'read',
        'rating',
    ];

    protected $casts = [
        'read' => ReadStatus::class,
    ];
}
