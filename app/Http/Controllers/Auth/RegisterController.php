<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'no_telp' => 'required|unique:users,no_telp',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5'
        ]);
        $data = [
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];
        User::create($data);

        return redirect()->route('login')->with('success', 'Selamat anda berhasil register');
    }
}
