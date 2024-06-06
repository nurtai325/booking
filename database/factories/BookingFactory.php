<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
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
        $service = Service::where('service_id', '>', '0')->first();
        $start_time = $this->faker->time('H:i');

        return [
            'start_time' => $start_time,
            'service_id' => $service->getKey(),
        ];
    }
}
