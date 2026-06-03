<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehiclesDataController extends Controller
{
    public static function middleware(): array
    {
        return [
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ];
    }

    public function index(Request $request)
    {
        $query = Vehicle::with('vehicle_category', 'vehicle_brand')
            ->orderBy('id', 'desc');

        $category = VehicleCategory::all();
        $brands = VehicleBrand::all();
        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('vehicle_category') && $request->vehicle_category != '') {
            $query->where('category_id', $request->vehicle_category);
        }

        // Filter berdasarkan merek
        if ($request->has('vehicle_brand') && $request->vehicle_brand != '') {
            $query->where('brand_id', $request->vehicle_brand);
        }

        // Filter status
        if ($request->has('operational_status') && $request->operational_status != '') {
            $query->where('operational_status', $request->operational_status);
        }

        // Filter harga (range)
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price_per_day', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        $vehicles = $query->paginate(5)->appends($request->except('page'));

        return view('admin.vehiclesData', compact(
            'vehicles',
            'category',
            'brands'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:vehicle_categories,id',
            'brand_id' => 'required|exists:vehicle_brands,id',
            'code' => 'required|unique:vehicles,code',
            'name' => 'required|max:150',
            'plate_number' => 'required|unique:vehicles,plate_number',
            'fuel_tank_capacity' => 'nullable|numeric',
            'description' => 'nullable',
            'price_per_day' => 'required|numeric',
            'operational_status' => 'required|in:active,inactive,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('vehicles', 'public');
        }
        Vehicle::create([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'code' => $request->code,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'plate_number' => $request->plate_number,
            'fuel_tank_capacity' => $request->fuel_tank_capacity,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'operational_status' => $request->operational_status,
            'image' => $image ?? null
        ]);

        if ($request) {
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        }
        return redirect()->back()->with('error', 'Data gagal ditambahkan');
    }

    /**
     * Update data
     */
    public function update(Request $request, string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $request->validate([
            'category_id' => 'required|exists:vehicle_categories,id',
            'brand_id' => 'required|exists:vehicle_brands,id',
            'code' => 'required|unique:vehicles,code,' . $vehicle->id,
            'name' => 'required|max:150',
            'plate_number' => 'required|unique:vehicles,plate_number,' . $vehicle->id,
            'fuel_tank_capacity' => 'nullable|numeric',
            'description' => 'nullable',
            'price_per_day' => 'required|numeric',
            'operational_status' => 'required|in:active,inactive,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('vehicles', 'public');
        }
        // if ($vehicle->image && Storage::disk('public')->exists($vehicle->image)) {
        //     Storage::disk('public')->delete($vehicle->image);
        // }

        $vehicle->update([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'code' => $request->code,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'plate_number' => $request->plate_number,
            'fuel_tank_capacity' => $request->fuel_tank_capacity,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'operational_status' => $request->operational_status,
            'image' => $image ?? $vehicle->image
        ]);

        if ($vehicle) {
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        }
        return redirect()->back()->with('error', 'Data gagal diupdate');
    }

    /**
     * Delete data
     */
    public function destroy($id)
    {
        $data = Vehicle::find($id);
        // Hapus file gambar di storage
        if ($data->image && Storage::disk('public')->exists($data->image)) {
            Storage::disk('public')->delete($data->image);
        }

        if ($data) {
            $data->delete();
        }
        return redirect()->back()->with('error', 'Data berhasil dihapus');
    }
}
