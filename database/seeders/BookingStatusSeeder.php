<?php

namespace Database\Seeders;

use App\Models\BookingStatus;
use Illuminate\Database\Seeder;

class BookingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending_payment'],
            ['name' => 'paid'],
            ['name' => 'payment_failed'],
            ['name' => 'ready_pickup'],
            ['name' => 'on_rent'],
            ['name' => 'returned'],
            ['name' => 'cancelled'],
            ['name' => 'expired'],
        ];

        foreach ($statuses as $status) {
            BookingStatus::create($status);
        }
    }
}
