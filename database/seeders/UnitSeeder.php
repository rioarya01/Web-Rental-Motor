<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = ['liter', 'buah', 'pcs'];

        foreach ($units as $unit) {
            Unit::create(['name' => $unit]);
        }
    }
}
