<?php

namespace Tests\Feature\Http\Controllers\Booking;

use App\Models\Booking;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class BookingManagerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetSchedule()
    {
        $user = User::find(1);
        $id = $user->getKey();

        $base_url = '/api/schedule';
        $url = $base_url . "?id=$id";
        $method = 'get';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);

        $newUser = User::factory()->create();
        $newId = $newUser->getKey();

        $newUrl = $base_url . "?id=$newId";

        $response = $this->makeRequest($user, $newUrl, $method);
        $response->assertStatus(400);
    }
}
