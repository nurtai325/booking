<?php

namespace Tests\Feature\Http\Controllers\Crud;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertsame;

class ServiceControllerTest extends TestCase
{
    use RefreshDatabase;

    use RefreshDatabase;

    public function testGetServiceById()
    {
        $user = User::find(1);
        $id = Service::find(1)->getKey();

        $base_url = '/api/service/getOne';
        $url = $base_url . "?id=$id";
        $method = 'get';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);

        $data = $response->json('data');
        assertSame($data['service_id'], $id);

        $url = $base_url . '?id=nknf';
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }

    public function testCreateService()
    {
        $user = User::factory()->create();
        $id = $user->getKey();

        $method = 'put';
        $base_url = '/api/service/create';
        $url = $base_url . "?id=$id";

        $data = [
            'name' => 'Test Service',
            'description' => 'Test Description',
            'price' => 34.43,
            'capacity' => 4,
            'duration' => 60
        ];
        $response = $this->makeJsonRequest($user, $url, $method, [
            'data' => $data,
        ]);
        $response->assertStatus(200);

        $data = $response->json('data');
        assertSame($data['user_id'], $id);

        $this->assertDatabaseHas('services', [
            'user_id' => $id
        ]);

        $data['name'] = 38;
        $data['price'] = 'some text';
        $response = $this->makeJsonRequest($user, $url, $method, $data);
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

    public function testGetAllServices()
    {
        $user = User::find(1);
        $id = $user->getKey();

        $base_url = '/api/service/getAll';
        $url = $base_url . "?id=$id";
        $method = 'get';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);

        $data = $response->json('data');
        self::assertIsArray($data);
        foreach ($data as $service) {
            assertSame($service['service_id'], $id);
        }

        $url = $base_url . '?id=nknf';
        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(400);

        $response = $this->makeRequest($user, $base_url, $method);
        $response->assertStatus(400);
    }

    public function testUpdateService()
    {
        $user = User::find(1);
        $id = Service::find(1)->getKey();

        $method = 'patch';
        $base_url = '/api/service/update';
        $url = $base_url . "?id=$id";

        $data = [
            'name' => 'Updated Service',
            'description' => 'Updated Description',
            'price' => 34.43,
            'capacity' => 4,
            'duration' => 60
        ];
        $response = $this->makeJsonRequest($user, $url, $method, [
            'data' => $data,
        ]);
        $response->assertStatus(200);

        $data = $response->json('data');
        assertSame($data['user_id'], $id);

        $this->assertDatabaseHas('services', [
            'user_id' => $id,
            'name' => 'Updated Service',
            'description' => 'Updated Description',
            'price' => 34.43,
            'capacity' => 4,
            'duration' => 60
        ]);

        $data['name'] = 38;
        $data['price'] = 'some text';
        $response = $this->makeJsonRequest($user, $url, $method, $data);
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

    public function testDeleteService()
    {
        $user = User::find(1);
        $id = Service::factory()->create()->getKey();
        Booking::factory(10)->create([
            'service_id' => $id
        ]);
        $fake_id = 4387;

        $base_url = '/api/service/delete';
        $url = $base_url . "?id=$id";
        $method = 'delete';

        $response = $this->makeRequest($user, $url, $method);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('services', [
            'service_id' => $id
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
