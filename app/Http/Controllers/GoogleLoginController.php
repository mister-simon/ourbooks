<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (ClientException|InvalidStateException $e) {
            return to_route('home')
                ->with('status', 'Unable to process login.');
        }

        // Associate an existing email address with a google account
        $emailUser = User::query()
            ->whereNull('google_id')
            ->where('email', $user->getEmail())
            ->first();

        $emailUser?->update(['google_id' => $user->getId()]);

        $authUser = User::updateOrCreate([
            'google_id' => $user->getId(),
        ], [
            'email' => $user->getEmail(),
            'name' => $user->getNickname(),
            'avatar' => $user->getAvatar(),
        ]);

        Auth::login($authUser);

        return to_route('home');
    }
}
