<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

    return redirect('/')
        ->with('status', 'Successfully logged in!');
})
    ->middleware('throttle', 'signed')
    ->name('auth.login');
