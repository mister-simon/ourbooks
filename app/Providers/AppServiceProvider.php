<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\Shelf;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'user' => User::class,
            'shelf' => Shelf::class,
            'book' => Book::class,
            'book_user' => BookUser::class,
        ]);
    }
}
