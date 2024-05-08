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

class FacebookLoginController extends Controller
{
    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback(): RedirectResponse
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        // dd($user->avatar_original . '&access_token=' . $user->token);
        $finduser = User::where('facebook_id', $user->id)->first();

        if ($finduser) {
            Auth::login($finduser, true);
            return redirect()->intended('dashboard');
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'facebook_id' => $user->id,
                'profile_picture' => $user->avatar_original . '&access_token=' . $user->token,
                'password' => encrypt('123456dummy'),
                'email_verified_at' => Carbon::now()
            ]);
            Auth::login($newUser);
            return redirect()->intended('dashboard');
        }
    }
}
