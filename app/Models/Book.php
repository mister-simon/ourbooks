<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class Book extends Model
{
    use HasFactory, HasUlids, Searchable;

    protected $fillable = [
        'id',
        'author_surname',
        'author_forename',
        'series_index',
        'title',
        'genre',
        'edition',
        'co_author',
        'series',
    ];

    public function shelf(): BelongsTo
    {
        return $this->belongsTo(Shelf::class);
    }

    public function bookUsers(): HasMany
    {
        return $this->hasMany(BookUser::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['read', 'rating'])
            ->withTimestamps()
            ->using(BookUser::class);
    }

    #[SearchUsingPrefix(['series_index'])]
    #[SearchUsingFullText(['series', 'author_surname', 'author_forename', 'title', 'genre', 'edition', 'co_author'])]
    public function toSearchableArray(): array
    {
        return [
            'series' => $this->series,
            'series_index' => (int) $this->series_index,
            'author_surname' => $this->author_surname,
            'author_forename' => $this->author_forename,
            'title' => $this->title,
            'genre' => $this->genre,
            'edition' => $this->edition,
            'co_author' => $this->co_author,
        ];
    }

    public function getSeriesTextAttribute()
    {
        return implode(' ', $this->only('series', 'series_index'));
    }

    public function getAuthorNameAttribute()
    {
        return trim(implode(' ', $this->only('author_forename', 'author_surname')));
    }

    public function getAuthorSurnameCharAttribute()
    {
        return $this->author_surname
            ? str($this->author_surname)->charAt(0)
            : '-';
    }

    public function getIntegerHashAttribute()
    {
        return collect(str_split($this->title))
            ->sum(fn ($char) => ord($char));
    }

    public function getWasReadAttribute()
    {
        return $this->bookUsers
            ->pluck('read')
            ->dd();
    }

    public function getBookUserAvgRatingAttribute()
    {
        return $this->bookUsers
            ->avg('rating');
    }
}
