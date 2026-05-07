<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Vehicle;
use App\Models\VehicleFeature;
use Illuminate\Database\Seeder;

class VehicleFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = Vehicle::all();
        $features = Feature::all();

        $quantities = [
            'Bensin' => 1,
            'Helm SNI' => 2,
            'Jas hujan' => 2,
            'STNK' => 1,
            'Tas belanja' => 1,
            'Sarung tangan' => 1,
        ];

        foreach ($vehicles as $vehicle) {
            foreach ($features as $feature) {
                if (isset($quantities[$feature->name])) {
                    VehicleFeature::create([
                        'vehicle_id' => $vehicle->id,
                        'feature_id' => $feature->id,
                        'qty' => $quantities[$feature->name],
                    ]);
                }
            }
        }
    }
}
