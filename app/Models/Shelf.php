<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shelf extends Model
{
    use HasUlids;
    use HasFactory;

    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function userListString()
    {
        return $this->users
            ->map(
                fn ($user) => $user->name ?? str($user->email)->limit(15)
            )
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->join(', ', ', and ');
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
