<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (! Hash::check($request->current_password, $request->user()->password)) {
            return back()
                ->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ], 'updatePassword');
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }
}
