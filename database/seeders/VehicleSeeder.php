<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = VehicleBrand::all();
        $categories = VehicleCategory::all();
        $faker = Faker::create();

        if ($brands->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Vehicle brands and categories must be seeded before running VehicleSeeder.');

            return;
        }

        $vehicleImages = [];

        foreach (range(1, 20) as $number) {
            $vehicleImages[] = sprintf('image_%02d.png', $number);
        }

        $bikeModel = [
            'Matic' => [
                ['brand' => 'Honda', 'name' => 'Vario 150'],
                ['brand' => 'Yamaha', 'name' => 'NMAX 155'],
                ['brand' => 'Yamaha', 'name' => 'Aerox 155'],
                ['brand' => 'Honda', 'name' => 'PCX 160'],
            ],
            'Sport' => [
                ['brand' => 'Yamaha', 'name' => 'R15'],
                ['brand' => 'Yamaha', 'name' => 'R25'],
                ['brand' => 'Yamaha', 'name' => 'R35'],
            ],
            'Bebek' => [
                ['brand' => 'Honda', 'name' => 'Beat'],
                ['brand' => 'Yamaha', 'name' => 'Fazzio'],
                ['brand' => 'Yamaha', 'name' => 'Mio M3'],
            ],
            'Trail' => [
                ['brand' => 'Kawasaki', 'name' => 'Ninja 300'],
                ['brand' => 'Kawasaki', 'name' => 'Ninja 650'],
            ],
            'Naked Bike' => [
                ['brand' => 'Suzuki', 'name' => 'Hayabusa'],
                ['brand' => 'Suzuki', 'name' => 'GSX'],
            ],
        ];

        for ($i = 0; $i < 10; $i++) {
            $category = $categories->random();
            $bike = $faker->randomElement($bikeModel[$category->name]);
            $brand = $brands->where('name', $bike['brand'])->first() ?? $brands->random();
            $name = $bike['brand'].' '.$bike['name'];

            Vehicle::updateOrCreate(
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'code' => strtoupper($brand->name[0]).$faker->bothify('??###'),
                    'name' => $name,
                    'slug' => Str::slug($name).'-'.$faker->unique()->numberBetween(1, 9999),
                    'plate_number' => $faker->regexify('[A-Z]{1,2} [0-9]{3,4} [A-Z]{1,2}'),
                    'fuel_tank_capacity' => $faker->optional()->randomFloat(2, 3, 12),
                    'description' => $faker->optional()->sentence(12),
                    'price_per_day' => $faker->numberBetween(80000, 250000),
                    'is_featured' => $faker->boolean(25),
                    'operational_status' => $faker->randomElement(['active', 'inactive', 'maintenance']),
                    'image' => $faker->randomElement($vehicleImages),
                ]
            );
        }
    }
}
