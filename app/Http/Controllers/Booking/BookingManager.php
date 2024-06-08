<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Record;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\InputBag;

class BookingManager extends Controller
{
    use ValidationTrait;

    private const validationArray = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'additional_info' => 'nullable|string',
    ];

    public function book(Request $request): JsonResponse {
        $id = $this->validateId($request);

        try {
            $booking = Booking::findOrFail($id);
            $booked = Record::where('booking_id', $id)
                ->where('canceled', false)
                ->get()
                ->reject($this->validateCreationDate())
                ->count();

            $service = $booking->service;
            $capacity = $service->capacity;

            if ($booked >= $capacity) {
                return response()->json([
                    'message' => 'already booked',
                    'capacity' => $capacity,
                    'booked' => $booked
                ], 400);
            }

            $bookingData = $this->validateInputData($request, self::validationArray);
            if ($bookingData instanceof JsonResponse) {
                return $bookingData;
            }

            $record = new Record();
            $record->fill($bookingData);
            $record->setAttribute('booking_id', $id);
            $record->save();

            return response()->json([
                'message' => 'successfully booked',
                'record' => $record,
            ],200);
        } catch (ModelNotFoundException|\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function unBook(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        try {
            $record = Record::findOrFail($id);

            if ($record->client_has_come) {
                return response()->json([
                    'error' => 'client has already come',
                ], 400);
            }

            $record->canceled = true;
            $record->save();

            return response()->json([
                'message' => 'successfully unbooked',
                'data' => $record
            ], 200);
        } catch (ModelNotFoundException | \Exception $e) {
            return response()->json([
                'error' => 'Record not found',
            ], 400);
        }
    }

    public function getSchedule(Request $request): JsonResponse {
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
            $bookings = $this->getBookings($service);
            $bookingInfo = new BookingInfo($service, $bookings);
            $data->add($bookingInfo);
        }

        return response()->json([
            'message' => 'schedule for the user is provided',
            'data' => $data,
        ],200);
    }

    private function getBookings(Service $service): Collection
    {
        $service_id = $service->getKey();
        $capacity = $service->capacity;

        return Booking::where('service_id', $service_id)
            ->get()
            ->reject(function ($booking) use ($capacity) {
                $count = $booking->records()
                    ->where('canceled', false)
                    ->get()
                    ->reject($this->validateCreationDate())
                    ->count();

                Log::info($count);
                Log::info($capacity);
                return $count >= $capacity;
            });
    }
}
