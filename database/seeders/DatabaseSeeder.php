<?php

namespace Database\Seeders;

use App\Models\Booking;
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
        ]);

        $service = Service::factory()->create([
            'user_id' => $user->getKey()
        ]);

        Booking::factory(10)->create([
            'service_id' => $service->getKey()
        ]);
    }
}
