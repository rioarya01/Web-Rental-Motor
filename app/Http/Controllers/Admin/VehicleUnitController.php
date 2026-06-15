<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validateWithBag('createUnit', [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:units,name',
            ],
        ], [
            'name.required' => 'Nama satuan wajib diisi.',
            'name.max' => 'Nama satuan maksimal 255 karakter.',
            'name.unique' => 'Nama satuan sudah tersedia.',
        ]);

        Unit::create([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('vehicle-feature.index')
            ->with('success', 'Data satuan berhasil ditambahkan.');
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
    public function update(Request $request, Unit $unit)
    {
        $request->validateWithBag('updateUnit_' . $unit->id, [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('units', 'name')->ignore($unit->id),
            ],
        ], [
            'name.required' => 'Nama satuan wajib diisi.',
            'name.max' => 'Nama satuan maksimal 255 karakter.',
            'name.unique' => 'Nama satuan sudah tersedia.',
        ]);

        $unit->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('vehicle-feature.index')
            ->with('success', 'Data satuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        if ($unit->features()->exists()) {
            return redirect()
                ->route('vehicle-feature.index')
                ->with(
                    'error',
                    'Satuan tidak dapat dihapus karena masih digunakan oleh perlengkapan.'
                );
        }

        $unit->delete();

        return redirect()
            ->route('vehicle-feature.index')
            ->with('success', 'Data satuan berhasil dihapus.');
    }
}
