<?php

namespace App\Http\Controllers\Booking;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Collection;

class BookingInfo
{
    public Service $service;
    public Collection $bookings;
    public int $capacity;

    public function __construct(Service $service)
    {
        $this->service = $service;
        $this->bookings = $this->getBookings($service);
    }

    private function getBookings(Service $service): Collection
    {
        $service_id = $service->getKey();
        $capacity = $service->getAttribute('capacity');
        $this->capacity = $capacity;

        $bookings = Booking::where('service_id', $service_id);
        $bookings->reject(function ($booking) use ($capacity) {
            $count = $booking->records()->count();
            return $count >= $capacity;
        });

        return $this->bookings;
    }
}
