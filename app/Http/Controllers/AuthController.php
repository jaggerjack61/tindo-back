<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user= User::where('email',$request->email)->first();
            if($user->access_level !='admin') {
                Auth::logout();
                return back()->with('error','You are not authorized to access this page.');
            }
            //$request->session()->regenerate();
            //dd('here');
            return redirect()->route('dashboard');
        }

        return back()->with('error','Wrong email or password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('show-login');
    }


}
