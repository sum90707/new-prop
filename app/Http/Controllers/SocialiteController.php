<?php

namespace App\Http\Controllers;

use Auth;
use Socialite;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function redirectToProvider(Request $request)
    {
        // \Session::put('u2f.registerData', $request);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $google = Socialite::driver('google')->user();
        $user = User::where('email', '=', $google->getEmail())
                    ->first();

        if (!$user) {

            $user = new User([
                'name' => $google->getName(),
                'email' => $google->getEmail(),
                'role_id' => 3,
                'api_token' => Str::random(60),
                'language' => 'tw',
                'password' => 'formGoogle'
            ]);
        }

        // $user->google_token = $google->token;
        $user->save();
        
        Auth::login($user);

        return redirect($this->redirectTo);
    }
}
