<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;

class VehicleCategoryController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => AdminMiddleware::class,
        ];
    }

    public function index()
    {
        $categories = \App\Models\VehicleCategory::orderBy('id', 'desc')->paginate(10);
        $brand = \App\Models\VehicleBrand::orderBy('id', 'desc')->paginate(10);

        return view('admin.vehicleCategoryBrand', compact('categories', 'brand'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\VehicleCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = \App\Models\VehicleCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = \App\Models\VehicleCategory::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori kendaraan berhasil dihapus.');
    }
}
