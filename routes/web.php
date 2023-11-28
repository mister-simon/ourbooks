<?php

use App\Http\Controllers\ShelfController;
use App\Livewire\BookCreate;
use App\Livewire\ShelfCreate;
use App\Livewire\ShelfInviteCreate;
use App\Models\ShelfInvite;
use App\Notifications\InvitedToShelf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
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

    Route::get('shelves/create', ShelfCreate::class)
        ->name('shelves.create');

    Route::get('shelves/{shelf}', [ShelfController::class, 'show'])
        ->name('shelves.show');

    Route::get('shelves/{shelf}/book/create', BookCreate::class)
        ->name('shelves.book.create');

    Route::get('shelves/{shelf}/user/create', ShelfInviteCreate::class)
        ->name('shelves.user.create');
});

if (config('app.debug')) {
    Route::get('debug/invite', function () {
        /** @var ShelfInvite */
        $invite = ShelfInvite::latest()
            ->firstOrFail();

        // Show the mailable directly if possible
        if ($invite->user) {
            return (new InvitedToShelf($invite))
                ->toMail($invite->user);
        }

        // Send the mailable locally -> Check mailhog / mailpit
        if (App::isLocal()) {
            $invite->notifyUser();
        }

        // Get a fake representation of the mailable
        Notification::fake();
        $invite->notifyUser();

        return Notification::sentNotifications();
    });
}
