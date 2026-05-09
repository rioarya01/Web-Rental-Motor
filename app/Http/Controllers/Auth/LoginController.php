<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        // abort(500);
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->route('home.admin');
            } elseif ($user->role == 'user') {
                return redirect()->route('home.user');
            }
        }

        return redirect()->route('login')->with('failed', 'Username atau Password Salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Kamu berhasil logout');
    }
}
