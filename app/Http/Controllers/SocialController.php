<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Laravel\Socialite\Facades\Socialite as FacadesSocialite;
use Socialite;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller
{
    // Redirecting to providers
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Callback Function
    public function Callback($provider)
    {
        $user =   Socialite::driver($provider)->stateless()->user();
        // $users       =   User::where(['email' => $userSocial->getEmail()])->first();

        // OAuth 2.0 providers...
        $token = $user->token;

        // All providers...
        echo "<br>user id: " . $user->getId();
        echo "<br>Nick name = " . $user->getNickname();
        echo "<br>Full Name: " . $user->getName();
        echo "<br>Email: " . $user->getEmail();
        echo "<br>Avatar: " . $user->getAvatar();
        $user = Socialite::driver($provider)->userFromToken($token);
        echo "<hr>User from token <hr><pre>";
        print_r($user);
    }

    // API Function for Social login -----------------------------------

    // Function for login
    public function apiSocialLogin(Request $request){
        $validator = Validator::make($request->all(), [
            "token" => "required",
            "provider" => "required"
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        // Getting user details from token
        $token = $request['token'];
        $user = Socialite::driver($request['provider'])->userFromToken($token);

        // echo "<br>user id: " . $user->getId();
        // echo "<br>Nick name = " . $user->getNickname();
        // echo "<br>Full Name: " . $user->getName();
        // echo "<br>Email: " . $user->getEmail();
        // echo "<br>Avatar: " . $user->getAvatar();
        // print_r($user);
        $username = $user->getName();
        return response()->json(['message' => "Welcome $username"]);
    }
    // Function for Registration
    public function apiSocialSignUp(Request $request){
        $request->validate([
            'token' => 'required'
        ]);
    }

    // API Social login function ends --------------------------------------
}
