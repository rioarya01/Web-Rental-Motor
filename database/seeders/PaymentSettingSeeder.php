<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentSetting;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentSetting::create([
            'bank_bca' => '0123456789',
            'bank_mandiri' => '9876543210',
            'account_name' => 'Admin Rental Motor',
            'whatsapp_number' => '6285735717807',
        ]);
    }
}
