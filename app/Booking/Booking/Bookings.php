<?php

namespace App\Booking\Booking;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

class Bookings
{
    public Booking $booking;
    public Collection $records;

    public function __construct(Booking $booking, Collection $records)
    {
        $this->booking = $booking;
        $this->records = $records;
    }
}
