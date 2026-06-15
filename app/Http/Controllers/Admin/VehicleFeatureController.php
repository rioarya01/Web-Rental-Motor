<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $features = Feature::with('unit')
            ->when($request->filled('feature_search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->feature_search . '%')
                    ->orWhereHas('unit', function ($unitQuery) use ($request) {
                        $unitQuery->where('name', 'like', '%' . $request->feature_search . '%');
                    });
            })
            ->latest()
            ->paginate(5, ['*'], 'features_page')
            ->withQueryString();

        $units = Unit::withCount('features')
            ->when($request->filled('unit_search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->unit_search . '%');
            })
            ->latest()
            ->paginate(5, ['*'], 'units_page')
            ->withQueryString();

        $unitOptions = Unit::orderBy('name')->get();

        return view('admin.vehicleFeatureUnit', compact(
            'features',
            'units',
            'unitOptions'
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
        $request->validateWithBag('createFeature', [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('features', 'name')
                    ->where(function ($query) use ($request) {
                        return $query->where('unit_id', $request->unit_id);
                    }),
            ],
            'unit_id' => [
                'nullable',
                'exists:units,id',
            ],
        ], [
            'name.required' => 'Nama perlengkapan wajib diisi.',
            'name.max' => 'Nama perlengkapan maksimal 255 karakter.',
            'name.unique' => 'Perlengkapan dengan satuan tersebut sudah tersedia.',
            'unit_id.exists' => 'Satuan yang dipilih tidak ditemukan.',
        ]);

        Feature::create([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
        ]);

        return redirect()
            ->route('vehicle-feature.index')
            ->with('success', 'Data perlengkapan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        $request->validateWithBag('updateFeature_' . $feature->id, [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('features', 'name')
                    ->where(function ($query) use ($request) {
                        return $query->where('unit_id', $request->unit_id);
                    })
                    ->ignore($feature->id),
            ],
            'unit_id' => [
                'nullable',
                'exists:units,id',
            ],
        ], [
            'name.required' => 'Nama perlengkapan wajib diisi.',
            'name.max' => 'Nama perlengkapan maksimal 255 karakter.',
            'name.unique' => 'Perlengkapan dengan satuan tersebut sudah tersedia.',
            'unit_id.exists' => 'Satuan yang dipilih tidak ditemukan.',
        ]);

        $feature->update([
            'name' => $request->name,
            'unit_id' => $request->unit_id,
        ]);

        return redirect()
            ->route('vehicle-feature.index')
            ->with('success', 'Data perlengkapan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        if ($feature->vehicles()->exists()) {
            return redirect()
                ->route('vehicle-feature.index')
                ->with(
                    'error',
                    'Perlengkapan tidak dapat dihapus karena masih digunakan pada kendaraan.'
                );
        }

        $feature->delete();

        return redirect()
            ->route('vehicle-feature.index')
            ->with('success', 'Data perlengkapan berhasil dihapus.');
    }
}
