<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Login Route
Route::get('login/{user}', function (User $user) {
    Auth::login($user);

    // Verify the user on their first login
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    if ($user->name === null) {
        return to_route('profile');
    }

    return redirect()
        ->intended('/')
        ->with('status', 'Successfully logged in!');
})
    ->middleware('throttle', 'signed')
    ->name('auth.login');
