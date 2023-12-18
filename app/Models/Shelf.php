<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Shelf extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'id',
        'title',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public function invites(): HasMany
    {
        return $this->hasMany(ShelfInvite::class);
    }

    public function userListString()
    {
        return $this->users
            ->map(fn ($user) => $user->readable)
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->join(', ', ', and ');
    }

    public static function getShelfAuthors(array $shelfIds)
    {
        return DB::table(
            DB::table('books')
                ->select([
                    'shelf_id',
                    DB::raw('concat(author_forename, " ", author_surname) as fullname'),
                    DB::raw('count(shelf_id)'),
                ])
                ->groupBy('shelf_id', 'fullname'),
            'authors'
        )
            ->select([
                'shelf_id as id',
                DB::raw('count(*) as unique_authors'),
            ])
            ->whereIn('shelf_id', $shelfIds)
            ->groupBy('shelf_id')
            ->pluck('unique_authors', 'id');
    }
}
