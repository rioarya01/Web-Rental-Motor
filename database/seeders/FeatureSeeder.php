<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $liter = Unit::where('name', 'liter')->first()?->id;
        $buah = Unit::where('name', 'buah')->first()?->id;

        $features = [
            ['name' => 'Bensin', 'unit_id' => $liter],
            ['name' => 'Helm SNI', 'unit_id' => $buah],
            ['name' => 'Jas hujan', 'unit_id' => $buah],
            ['name' => 'STNK', 'unit_id' => null],
            ['name' => 'Tas belanja', 'unit_id' => $buah],
            ['name' => 'Sarung tangan', 'unit_id' => $buah],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
