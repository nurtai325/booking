<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $booking = Booking::where('booking_id', '>', '0')->first();

        return [
            'name' => fake()->name(),
            'booking_id' => $booking->getKey(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
