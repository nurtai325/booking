<?php

namespace Tests\Feature\Http\Controllers\Crud;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use function PHPUnit\Framework\assertSame;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetBookingById()
    {
        $user = User::find(1);
        $id = Booking::find(1)->getKey();

        $base_url = '/api/booking/getOne';
        $url = $base_url . "?id=$id";
        $method = 'get';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);

        $data = $response->json('data');
        assertSame($data['booking_id'], $id);

        $url = $base_url . '?id=nknf';
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }

    public function testCreateBooking()
    {
        $user = User::find(1);
        $service = Service::factory()->create();
        $id = $service->getKey();

        $method = 'put';
        $base_url = '/api/booking/create';
        $url = $base_url . "?id=$id";

        $data = ['start_time' => '16:00:00'];
        $response = $this->makeJsonRequest($user, $url, $method, [
            'data' => $data,
        ]);
        $response->assertStatus(200);

        $data = $response->json('data');
        assertSame($data['service_id'], $id);

        $this->assertDatabaseHas('bookings', [
            'service_id' => $id
        ]);

        $response = $this->makeJsonRequest($user, $url, $method, [
            'start_time' => 3289
        ]);
        $response->assertStatus(400);

        $response = $this->makeJsonRequest($user, $url, $method, []);
        $response->assertStatus(400);

        $response = $this->makeJsonRequest($user, $base_url, $method, []);
        $response->assertStatus(400);

        $url = $base_url . '?id=2839';
        $response = $this->makeJsonRequest($user, $url, $method, []);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }

    public function testGetAllBookings()
    {
        $user = User::find(1);
        $id = $user->getKey();

        $base_url = '/api/booking/getAll';
        $url = $base_url . "?id=$id";
        $method = 'get';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);

        $data = $response->json('data');
        self::assertIsArray($data);
        foreach ($data as $booking) {
            assertSame($booking['service_id'], $id);
        }

        $url = $base_url . '?id=nknf';
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }

    public function testUpdateBooking()
    {
        $user = User::find(1);
        $service = Service::find(1);
        $id = $service->getKey();

        $method = 'patch';
        $base_url = '/api/booking/update';
        $url = $base_url . "?id=$id";
        $start_time = '19:00:00';

        $data = ['start_time' => $start_time];
        $response = $this->makeJsonRequest($user, $url, $method, [
            'data' => $data,
        ]);
        $response->assertStatus(200);
        $data = $response->json('data');
        assertSame($data['service_id'], $id);
        $this->assertDatabaseHas('bookings', [
            'service_id' => $id,
            'start_time' => $start_time,
        ]);

        $response = $this->makeJsonRequest($user, $url, $method, [
            'start_time' => '16hbds:00:00'
        ]);
        $response->assertStatus(400);

        $response = $this->makeJsonRequest($user, $url, $method, [
            'start_time' => 3289
        ]);
        $response->assertStatus(400);

        $response = $this->makeJsonRequest($user, $url, $method, []);
        $response->assertStatus(400);

        $response = $this->makeJsonRequest($user, $base_url, $method, []);
        $response->assertStatus(400);

        $url = $base_url . '?id=2839';
        $response = $this->makeJsonRequest($user, $url, $method, []);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }

    public function testDeleteBooking()
    {
        $user = User::find(1);
        $id = Booking::find(1)->getKey();
        $fake_id = 4387;

        $base_url = '/api/booking/delete';
        $url = $base_url . "?id=$id";
        $method = 'delete';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('bookings', [
            'booking_id' => $id
        ]);

        $url = $base_url . "?id=$fake_id";
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $url = $base_url . '?id=nknf';
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }
}
