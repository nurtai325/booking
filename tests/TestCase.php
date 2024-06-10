<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    protected $seed = true;

    protected function makeRequest($user, string $url, string $method): TestResponse
    {
        return $this->actingAs($user)
            ->withSession(['banned' => false])
            ->$method(env('APP_URL') . $url);
    }

    protected function makeJsonRequest($user, string $url, string $method, array $data): TestResponse
    {
        $method .= 'Json';

        return $this->actingAs($user)
            ->withSession(['banned' => false])
            ->$method(env('APP_URL') . $url, $data);
    }
}
