<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect according to role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }elseif($user->role=='seller'){
                 return redirect()->route('seller.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return back()->with('error', 'Invalid email or password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
