<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'booking_code' => 'BK-'.strtoupper($this->faker->unique()->bothify('??###')),
            'vehicle_id' => Vehicle::factory(),
            'user_id' => User::factory(),
            'booking_date' => now(),
            'rent_start' => now()->addDays(1),
            'rent_end' => now()->addDays(3),
            'duration_days' => 2,
            'price_per_day' => 100000,
            'discount_amount' => 0,
            'total_amount' => 200000,
            'booking_status_id' => BookingStatus::inRandomOrder()->first()?->id ?? BookingStatus::factory(),
            'pickup_address' => $this->faker->address(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
