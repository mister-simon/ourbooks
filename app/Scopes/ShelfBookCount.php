<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

final readonly class ShelfBookCount
{
    public function __invoke(Builder $builder): void
    {
        $builder->withCount('books');
    }
}
