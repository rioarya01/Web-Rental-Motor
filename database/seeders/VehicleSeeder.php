<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleCategory;
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

        if ($brands->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Vehicle brands and categories must be seeded before running VehicleSeeder.');

            return;
        }

        $faker = fake();

        $vehicleModels = [
            'Matic' => [
                'Vario 125',
                'NMAX 155',
                'Beat Street',
                'Scoopy',
                'Aerox 155',
                'Lexi',
                'Fino 125',
                'PCX 160',
            ],
            'Cub' => [
                'Supra GTR 150',
                'Genio',
                'Mio M3',
                'Fazzio',
                'Beat',
            ],
            'Underbone' => [
                'MX King 150',
                'Jupiter Z',
                'Sniper 155',
                'RSZ',
            ],
        ];

        $vehicleImages = [];

        foreach (range(1, 20) as $number) {
            $vehicleImages[] = sprintf('image_%02d.png', $number);
        }

        for ($i = 0; $i < 10; $i++) {
            $category = $categories->random();
            $brand = $brands->random();
            $modelNames = $vehicleModels[$category->name] ?? $vehicleModels['Matic'];

            $modelName = $faker->randomElement($modelNames);
            $name = "{$brand->name} {$modelName}";
            $slug = Str::slug($name) . "-{$i}";

            Vehicle::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'code' => strtoupper($brand->name[0]) . $faker->bothify('??###'),
                    'name' => $name,
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
