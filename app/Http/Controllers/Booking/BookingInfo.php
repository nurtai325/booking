<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Record;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BookingInfo
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
