<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Diskon Global (Berlaku untuk semua kendaraan)
        Discount::create([
            'name' => 'Promo Spesial Liburan',
            'percentage' => 5,
            'is_active' => true,
        ]);

        // Diskon Khusus Kategori Tertentu (Kategori ID 3 = Bebek)
        Discount::create([
            'name' => 'Promo Bebek Merdeka',
            'percentage' => 10,
            'category_id' => 3,
            'is_active' => true,
        ]);

        // Diskon Khusus Brand Tertentu (Brand ID 2 = Honda)
        Discount::create([
            'name' => 'Promo Spesial Honda',
            'percentage' => 15,
            'brand_id' => 2,
            'is_active' => true,
        ]);

        // Diskon Khusus Kendaraan Tertentu (Misal: Vehicle ID 1)
        Discount::create([
            'name' => 'Flash Sale Motor Pilihan',
            'percentage' => 20,
            'vehicle_id' => 1,
            'is_active' => true,
        ]);
    }
}
