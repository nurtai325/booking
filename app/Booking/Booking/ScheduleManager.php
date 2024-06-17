<?php

namespace App\Booking\Booking;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class ScheduleManager extends Controller
{
    use ValidationTrait;

    public function getFullSchedule(int $id): Collection {
        $data = new Collection();
        $services = Service::where('user_id', $id)->get();

        if (count($services) == 0) {
            return new Collection();
        }

        foreach ($services as $service) {
            $bookingsArray = [];
            $bookings = Booking::where('service_id', $service->getKey())->get();
            foreach ($bookings as $booking) {
                $bookingsArray[] = new Bookings($booking, $booking->records);
            }
            $bookingInfo = new BookingInfo($service, $bookingsArray);
            $data->add($bookingInfo);
        }

        return $data;
    }

    public function getAvailableSchedule(int $id): array | null {
        $data = [];
        $services = Service::where('user_id', $id)->get();

        if (count($services) == 0) {
            return null;
        }

        $bookingController = new BookingController();
        foreach ($services as $service) {
            $bookings = $bookingController->getAvailableBookings($service);
            $bookingInfo = new Schedule($service, $bookings);
            $data[] = $bookingInfo;
        }

        return $data;
    }
}
