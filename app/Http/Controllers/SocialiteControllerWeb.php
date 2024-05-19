<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Response;

class SocialiteController extends Controller
{
    public function loginSocial(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callbackSocial(string $provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $finduser = User::where($provider . '_id', $user->id)
                        ->orWhere('email', $user->email)
                        ->first();

        if ($finduser) {
            Auth::login($finduser, true);
            return Response::view('close_popup', ['redirectUrl' => 'http://localhost:3000/dashboard']);
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

            return redirect()->route('dashboard');
        }
    }
}
