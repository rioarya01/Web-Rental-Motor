<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_brands')->insert([
            [
                'name' => 'Yamaha',
            ],
            [
                'name' => 'Honda',
            ],
            [
                'name' => 'Suzuki',
            ],
            [
                'name' => 'Kawasaki',
            ],
        ]);
    }
}
