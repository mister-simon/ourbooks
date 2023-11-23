<?php

use App\Http\Controllers\ShelfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return to_route('shelves.index');
    }

    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('shelves', [ShelfController::class, 'index'])
        ->name('shelves.index');

    Route::get('shelves/{shelf}', [ShelfController::class, 'show'])
        ->name('shelves.show');
});
