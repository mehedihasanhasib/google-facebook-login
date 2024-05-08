<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {

        $user = Socialite::driver('google')->stateless()->user();
        $finduser = User::where('google_id', $user->id)->first();

        if ($finduser) {
            Auth::login($finduser, true);
            return redirect()->intended('dashboard');
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'profile_picture' => $user->avatar_original,
                'password' => encrypt('123456dummy'),
                'email_verified_at' => Carbon::now()
            ]);
            Auth::login($newUser);
            return redirect()->intended('dashboard');
        }
    }
}
