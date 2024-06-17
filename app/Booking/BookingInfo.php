<?php

namespace App\Booking;

use App\Http\Controllers\ValidationTrait;
use App\Models\Service;

class BookingInfo
{
    use ValidationTrait;

    public Service $service;
    public array $bookings;
    public int $capacity;

    public function __construct(Service $service, array $bookings)
    {
        $this->service = $service;
        $this->bookings = $bookings;
    }
}

