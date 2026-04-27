<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    // redirect
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    // callback
    public function callback($provider) {
        $socialLoginData = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'email' => $socialLoginData->email,
        ], [
            'name' => $socialLoginData->name,
            'nickname' => $socialLoginData->nickname,

            'provider' => $provider,
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
            'role' => 'user'
        ]);

        Auth::login($user);

        return to_route('userHome');
    }

}
