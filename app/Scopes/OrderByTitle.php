<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;

final readonly class OrderByTitle
{
    public function __invoke(Builder $builder): void
    {
        $builder->orderBy('title');
    }
}
