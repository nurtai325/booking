<?php

namespace App\Booking\Booking;

use App\Http\Controllers\ValidationTrait;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class Schedule
{
    use ValidationTrait;

    public Service $service;
    public Collection $bookings;
    public int $capacity;

    public function __construct(Service $service, Collection $bookings)
    {
        $this->service = $service;
        $this->bookings = $bookings;
    }
}
