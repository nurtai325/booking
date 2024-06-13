<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Crud\BookingController;
use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;use Psy\Util\Json;

class ScheduleManager extends Controller
{
    use ValidationTrait;

    public function getFullSchedule(Request $request): JsonResponse {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        $data = new Collection();
        $services = Service::where('user_id', $id)->get();

        if (count($services) == 0) {
            return response()->json([
                'error' => "user doesn't have any services"
            ], 400);
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

        return response()->json([
            'message' => 'schedule for the user is provided',
            'data' => $data,
        ],200);
    }

    public function getAvailableSchedule(int $id): array | bool {
        $data = [];
        $services = Service::where('user_id', $id)->get();

        if (count($services) == 0) {
            return false;
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
