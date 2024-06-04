<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceGroup;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Nurtai',
            'email' => 'nurtolymbek23@gmail.com',
           'password' => bcrypt('password'),
            'address' => 'Mukanov 51, Zhanatalap, Almaty',
            'phone' => '87052505839',
            'company_type' => 'football'
        ]);

        Service::factory()->create();
        Booking::factory()->create();
    }
}
