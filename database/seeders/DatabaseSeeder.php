<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            VehicleCategorySeeder::class,
            VehicleBrandSeeder::class,
            VehicleSeeder::class,
            BookingStatusSeeder::class,
            PaymentStatusSeeder::class,
            UnitSeeder::class,
            FeatureSeeder::class,
            VehicleFeatureSeeder::class,
        ]);
    }
}
