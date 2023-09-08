<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\Shelf;
use App\Models\User;
use App\View\Components\Card;
use App\View\Components\Main;
use App\View\Components\Nav;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
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

        Blade::components([
            Main::class,
            Nav::class,
            Card::class,
        ], 'app');
    }
}
