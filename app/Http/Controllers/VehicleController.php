<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filters
        $filters = collect($request->only(['search', 'type']))
            ->filter() 
            ->all();

        $query = Vehicle::with('vehicle_category', 'vehicle_brand')
                    ->orderBy('id', 'desc');

        // Search Filter
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        // Type Filter
        if (!empty($filters['type'])) {
            $query->whereHas('vehicle_category', function ($q) use ($filters) {
                $q->whereRaw('LOWER(name) = ?', [strtolower($filters['type'])]);
            });
        }

        $vehicles = $query->paginate(6)->withQueryString();

        return view('vehicle', compact('vehicles'));
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
    public function show(Vehicle $vehicle)
    {
        //
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
