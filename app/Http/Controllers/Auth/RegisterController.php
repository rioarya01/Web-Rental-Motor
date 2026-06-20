<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'no_telp' => 'required|numeric|digits_between:10,15|unique:users,no_telp',
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\s\.\']+$/u'
            ],
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        
        User::create([
            'no_telp' => $request->no_telp,
            'name' => Str::title(trim($request->name)),
            'email' => strtolower(trim($request->email)),
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Selamat anda berhasil register');
    }
}
