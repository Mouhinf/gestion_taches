<?php

namespace App\Http\Controllers;

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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials))
        {
            $user = Auth::user();

            if ($user->role_id == 1) {
                return redirect('/admin/dashboard');
            }

            if ($user->role_id == 2) {
                return redirect('/manager/dashboard');
            }

            return redirect('/user/dashboard');
        }

        return back()->with('error', 'Email ou mot de passe incorrect');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}