<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_id' => Booking::factory(),
            'payment_code' => 'PAY-'.strtoupper($this->faker->unique()->bothify('??###')),
            'method' => $this->faker->randomElement(['cash', 'bank_transfer', 'virtual_account', 'e_wallet', 'qris', 'credit_card', 'debit_card']),
            'provider' => $this->faker->randomElement(['midtrans', 'xendit', 'tripay', 'bank_bca', 'bank_bni', 'bank_bri', 'gopay', 'ovo', 'dana', 'manual_transfer']),
            'external_reference' => $this->faker->uuid(),
            'amount' => 200000,
            'payment_status_id' => PaymentStatus::inRandomOrder()->first()?->id ?? PaymentStatus::factory(),
            'expired_at' => now()->addHours(2),
            'paid_at' => null,
            'failure_reason' => null,
        ];
    }
}
