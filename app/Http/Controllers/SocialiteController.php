<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function loginSocial(string $provider): RedirectResponse
    {
        if ($provider == 'linkedin') {
            return Socialite::driver('linkedin-openid')->redirect();
        }
        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial(string $provider)
    {
        $newProvider = $provider == 'linkedin' ? $provider . '-openid' : $provider;
        $user = Socialite::driver($newProvider)->stateless()->user();

        $finduser = User::where($provider . '_id', $user->id)->first();

        if ($finduser) {
            Auth::login($finduser, true);
            return redirect()->intended('dashboard');
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                $provider . '_id' => $user->id,
                'profile_picture' => $provider == 'facebook' ? $user->avatar_original . '&access_token=' . $user->token : $user->avatar,
                'password' => encrypt('123456dummy'),
                'email_verified_at' => Carbon::now()
            ]);
            Auth::login($newUser);
            return redirect()->intended('dashboard');
        }
    }
}
