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

        $vehicles = [
            [
                'category' => 'Matic',
                'brand' => 'Honda',
                'name' => 'Honda Vario 150',
                'fuel' => 5.5,
                'price' => 100000,
                'status' => 'active',
                'image' => 'image_01.png'
            ],
            [
                'category' => 'Matic',
                'brand' => 'Yamaha',
                'name' => 'Yamaha NMAX 155',
                'fuel' => 7.1,
                'price' => 150000,
                'status' => 'active',
                'image' => 'image_02.png'
            ],
            [
                'category' => 'Matic',
                'brand' => 'Yamaha',
                'name' => 'Yamaha Aerox 155',
                'fuel' => 5.5,
                'price' => 140000,
                'status' => 'maintenance',
                'image' => 'image_03.png'
            ],
            [
                'category' => 'Matic',
                'brand' => 'Honda',
                'name' => 'Honda PCX 160',
                'fuel' => 8.1,
                'price' => 160000,
                'status' => 'active',
                'image' => 'image_04.png'
            ],
            [
                'category' => 'Sport',
                'brand' => 'Yamaha',
                'name' => 'Yamaha R15',
                'fuel' => 11.0,
                'price' => 180000,
                'status' => 'active',
                'image' => 'image_05.png'
            ],
            [
                'category' => 'Sport',
                'brand' => 'Yamaha',
                'name' => 'Yamaha R25',
                'fuel' => 14.0,
                'price' => 250000,
                'status' => 'inactive',
                'image' => 'image_06.png'
            ],
            [
                'category' => 'Bebek',
                'brand' => 'Honda',
                'name' => 'Honda Supra X',
                'fuel' => 4.0,
                'price' => 80000,
                'status' => 'active',
                'image' => 'image_07.png'
            ],
            [
                'category' => 'Bebek',
                'brand' => 'Yamaha',
                'name' => 'Yamaha Jupiter MX',
                'fuel' => 4.2,
                'price' => 85000,
                'status' => 'active',
                'image' => 'image_08.png'
            ],
            [
                'category' => 'Trail',
                'brand' => 'Kawasaki',
                'name' => 'Kawasaki KLX 150',
                'fuel' => 6.9,
                'price' => 175000,
                'status' => 'active',
                'image' => 'image_09.png'
            ],
            [
                'category' => 'Naked Bike',
                'brand' => 'Suzuki',
                'name' => 'Suzuki GSX-S150',
                'fuel' => 11.0,
                'price' => 165000,
                'status' => 'active',
                'image' => 'image_10.png'
            ],
        ];

        foreach ($vehicles as $index => $v) {
            $brand = $brands->where('name', $v['brand'])->first();
            $category = $categories->where('name', $v['category'])->first();

            if (!$brand || !$category) continue;

            $slug = Str::slug($v['name']) . '-' . ($index + 1);

            Vehicle::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'brand_id' => $brand->id,
                    'code' => strtoupper(substr($brand->name, 0, 1)) . rand(1000, 9999),
                    'name' => $v['name'],
                    'slug' => $slug,
                    'plate_number' => 'B ' . rand(1000, 9999) . ' ABC',
                    'fuel_tank_capacity' => $v['fuel'],
                    'description' => 'Motor ' . $v['name'] . ' dalam kondisi prima, siap digunakan untuk perjalanan Anda.',
                    'price_per_day' => $v['price'],
                    'is_featured' => rand(0, 1),
                    'operational_status' => $v['status'],
                    'image' => $v['image'],
                ]
            );
        }
    }
}
