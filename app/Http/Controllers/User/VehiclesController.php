<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index(Request $request)
    {
        // Filter
        $query = Vehicle::with('vehicle_category', 'vehicle_brand')
            ->orderBy('id', 'desc');
            
        $category = VehicleCategory::all();
        $brands = VehicleBrand::all();
        
        // Search Filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        // Filter berdasarkan kategori
        if ($request->filled('vehicle_category')) {
            $query->where('category_id', $request->vehicle_category);
        }
        // Filter brand
        if ($request->filled('vehicle_brand')) {
            $query->where('brand_id', $request->vehicle_brand);
        }
        // Filter status
        if ($request->filled('operational_status')) {
            $query->where('operational_status', $request->operational_status);
        }
        // Filter harga minimum
        if ($request->filled('min_price')) {
            $query->where('price_per_day', '>=', $request->min_price);
        }
        // Filter harga maximum
        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }
        $vehicles = $query->paginate(6)->withQueryString();
        return view('user.vehicles-list', compact(
            'vehicles',
            'category',
            'brands'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $vehicle = Vehicle::where('slug', $slug)->firstOrFail();
        return view('user.vehicle-details', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
