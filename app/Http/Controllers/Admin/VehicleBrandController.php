<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => AdminMiddleware::class,
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\VehicleBrand::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Merek kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $brand = \App\Models\VehicleBrand::findOrFail($id);
        $brand->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Merek kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $brand = \App\Models\VehicleBrand::findOrFail($id);
        $brand->delete();

        return redirect()->back()->with('success', 'Merek kendaraan berhasil dihapus.');
    }
}
