<?php

namespace Database\Seeders;

use App\Models\PaymentStatus;
use Illuminate\Database\Seeder;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending'],
            ['name' => 'paid'],
            ['name' => 'failed'],
            ['name' => 'expired'],
            ['name' => 'refunded'],
        ];

        foreach ($statuses as $status) {
            PaymentStatus::create($status);
        }
    }
}
