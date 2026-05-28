<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::where('role', 'user')->orderBy('id', 'desc')->paginate(10);
        return view('admin.customers', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'no_telp' => 'nullable|string|max:20|unique:users,no_telp',
                'address' => 'nullable|string|max:255',
                'ktp_number' => 'nullable|string|max:20|unique:users,ktp_number',
                'password' => 'required|string|min:8',
                'status' => 'required|in:active,non-active,blocked',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'username.required' => 'Username wajib diisi.',
                'username.unique' => 'Username sudah digunakan.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'no_telp.unique' => 'Nomor telepon sudah digunakan.',
                'ktp_number.unique' => 'Nomor KTP sudah digunakan.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal 8 karakter.',
                'status.required' => 'Status wajib diisi.',
            ]
        );

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
            'ktp_number' => $request->ktp_number,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = User::findOrFail($id);
        $request->validate(
            [
                'name' => 'nullable|string|max:255',
                'username' => 'nullable|string|max:255|unique:users,username,' . $customer->id,
                'email' => 'nullable|email|unique:users,email,' . $customer->id,
                'no_telp' => 'nullable|string|max:20|unique:users,no_telp,' . $customer->id,
                'address' => 'nullable|string|max:255',
                'ktp_number' => 'nullable|string|max:20|unique:users,ktp_number,' . $customer->id,
                'password' => 'nullable|string|min:8',
                'status' => 'nullable|in:active,non-active,blocked',
            ],
            [
                'username.unique' => 'Username sudah digunakan.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'no_telp.unique' => 'Nomor telepon sudah digunakan.',
                'ktp_number.unique' => 'Nomor KTP sudah digunakan.',
                'password.min' => 'Password minimal 8 karakter.',
                'status.in' => 'Status harus salah satu dari: active, non-active, blocked.',
            ]
        );

        $customer->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
            'ktp_number' => $request->ktp_number,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        if ($request) {
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
        }
        return redirect()->route('customers.index')->with('error', 'Failed to update customer.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = \App\Models\User::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}