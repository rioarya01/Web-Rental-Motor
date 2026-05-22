<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('vehicle_categories')->insert([
            [
                'name' => 'Matic',
            ],
            [
                'name' => 'Sport',
            ],
            [
                'name' => 'Bebek',
            ],
            [
                'name' => 'Trail',
            ],
            [
                'name' => 'Naked Bike',
            ],
        ]);
    }
}
