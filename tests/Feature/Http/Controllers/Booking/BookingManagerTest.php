<?php

namespace Tests\Feature\Http\Controllers\Booking;

use App\Models\Booking;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function testUnBook()
    {
        $user = User::find(1);
        $record = Record::find(1);
        $id = $record->getKey();

        $base_url = '/api/unbook';
        $url = $base_url . "?id=$id";
        $method = 'post';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);
        $this->assertDatabaseHas('records', [
            'record_id' => $id,
            'canceled' => true,
        ]);

        $url = $base_url . "?id=67";
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $url = $base_url . '?id=nknf';
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }

    public function testBook()
    {
        $user = User::find(1);
        $booking = Booking::find(1);
        $id = $booking->getKey();

        $base_url = '/api/book';
        $url = $base_url . "?id=$id";
        $method = 'post';

        $data = [
            'phone' => '75479373',
            'name' => 'Nurtai'
        ];
        $response = $this->makeJsonRequest($user, $url, $method, [
            'data' => $data,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('records', [
            'phone' => '75479373',
            'name' => 'Nurtai'
        ]);

        $wrongData = [
            'phone' => 34,
            'notName' => 'Nurtai'
        ];
        $response = $this->makeJsonRequest($user, $url, $method, [
            'data' => $wrongData,
        ]);
        $response->assertStatus(400);

        $response = $this->makeJsonRequest($user, $url, $method, [
            'data' => $data,
        ]);
        $response->assertStatus(400);
    }
}
