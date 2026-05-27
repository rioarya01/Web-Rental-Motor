<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'nullable|string|max:20|unique:users,no_telp',
            'address' => 'nullable|string|max:255',
            'ktp_number' => 'nullable|string|max:20|unique:users,ktp_number',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,non-active,blocked',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
            'ktp_number' => $request->ktp_number,
            'password' => bcrypt($request->password),
            'role' => 'user',
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = User::findOrFail($id);
        $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $customer->id,
            'email' => 'nullable|email|unique:users,email,' . $customer->id,
            'no_telp' => 'nullable|string|max:20|unique:users,no_telp,' . $customer->id,
            'address' => 'nullable|string|max:255',
            'ktp_number' => 'nullable|string|max:20|unique:users,ktp_number,' . $customer->id,
            'password' => 'nullable|string|min:8',
            'status' => 'nullable|in:active,non-active,blocked',
        ]);

        $customer->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'address' => $request->address,
            'ktp_number' => $request->ktp_number,
            'password' => $request->password ? bcrypt($request->password) : $customer->password,
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
