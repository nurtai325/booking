<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Nurtai',
            'email' => 'nurtolymbek23@gmail.com',
            'password' => bcrypt('password'),
            'address' => 'Mukanov 51, Zhanatalap, Almaty',
            'phone' => '87052505839',
            'company_type' => 'football',
            'bot' => '7037106255:AAEvO05WgoOGWjRB9gbhtmxNdvfyLLrQi4E',
        ]);

        $service = Service::factory(10)->create([
            'user_id' => $user->getKey(),
            'capacity' => 6,
        ]);

        $service->each(function ($service) {
            $booking = Booking::factory()->create([
                'service_id' => $service->getKey(),
            ]);

            Record::factory(5)->create([
                'booking_id' => $booking->getKey(),
            ]);


            Booking::factory()->create([
                'service_id' => $service->getKey(),
            ]);
        });

        $additionalBooking = Booking::factory()->create([
            'service_id' => $service->first()->getKey(), // or any specific service you want to assign it to
        ]);

        // Optional: Adding records to the additional booking
        Record::factory(5)->create([
            'booking_id' => $additionalBooking->getKey(),
        ]);

//        $booking = Booking::factory()->create([
//            'service_id' => $service->getKey()
//        ]);
//
//        Record::factory(5)->create([
//            'booking_id' => $booking->getKey(),
//        ]);
    }
}
