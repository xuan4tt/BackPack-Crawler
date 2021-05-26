<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{   
    public function login(){
        return view('login');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home.index');
    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function googleSignin(){
        $user = Socialite::driver('google')->user();
        $user_login = User::where('email', $user->email)->first();
        if($user_login){
            Auth::login($user_login);
            return redirect()->route('home.index');
        }
        else{
            $add_user = User::create([
                'google_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'password' => password_hash('1234567890', PASSWORD_DEFAULT)
            ]);
            Auth::login($add_user);
            return redirect()->route('home.index');
        }
    }

    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookSignin(){
        $user = Socialite::driver('facebook')->stateless()->user();
        $user_login = User::where('email', $user->email)->first();
        if($user_login){
            Auth::login($user_login);
            return redirect('http://domain1.com/');
        }
        else{
            $add_user = User::create([
                'facebook_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'password' => password_hash('1234567890', PASSWORD_DEFAULT)
            ]);
            Auth::login($add_user);
            return redirect('http://domain1.com/');
        }
    }
}
