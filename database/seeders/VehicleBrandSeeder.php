<?php

namespace Database\Seeders;

use App\Models\VehicleBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VehicleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = ['Honda', 'Yamaha'];

        $data = [];

        foreach ($brands as $brand) {
            $data[] = [
                'name' => $brand,
                'slug' => Str::slug($brand),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('vehicle_brands')->insert($data);
    }
}
