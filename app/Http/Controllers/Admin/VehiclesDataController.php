<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
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

        // Filter brand
        if ($request->has('vehicle_brand') && $request->vehicle_brand != '') {
            $query->where('brand_id', $request->vehicle_brand);
        }

        // Filter status
        $query->when($request->operational_status, function ($q, $status) {
            $q->where('operational_status', $status);
        });

        // Filter harga (range)
        $query->when($request->min_price, function ($q, $min) {
            $q->where('price_per_day', '>=', $min);
        });

        $query->when($request->max_price, function ($q, $max) {
            $q->where('price_per_day', '<=', $max);
        });

        $vehicles = $query->paginate(5)->appends($request->except('page'));

        return view('admin.vehiclesData', compact(
            'vehicles',
            'category',
            'brands'
        ));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:vehicle_categories,id',
            'brand_id' => 'required|exists:vehicle_brands,id',
            'code' => 'required|unique:vehicles,code',
            'name' => 'required|max:150',
            'plate_number' => 'required|unique:vehicles,plate_number',
            'fuel_tank_capacity' => 'nullable|numeric',
            'description' => 'nullable',
            'price_per_day' => 'required|numeric',
            'operational_status' => 'required|in:active,inactive,maintenance',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('vehicles', 'public');
        }

        // Slug
        $validated['slug'] = Str::slug($request->name);

        // Featured
        $validated['is_featured'] = $request->has('is_featured');

        Vehicle::create($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle created successfully');
    }

    /**
     * Update data
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:vehicle_categories,id',
            'brand_id' => 'required|exists:vehicle_brands,id',
            'code' => 'required|unique:vehicles,code,' . $vehicle->id,
            'name' => 'required|max:150',
            'plate_number' => 'required|unique:vehicles,plate_number,' . $vehicle->id,
            'fuel_tank_capacity' => 'nullable|numeric',
            'description' => 'nullable',
            'price_per_day' => 'required|numeric',
            'operational_status' => 'required|in:active,inactive,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload image baru
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('vehicles', 'public');
        }

        // Update slug
        $validated['slug'] = Str::slug($request->name);

        // Featured
        $validated['is_featured'] = $request->has('is_featured');

        $vehicle->update($validated);

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    /**
     * Delete data
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehicle deleted successfully');
    }
}
