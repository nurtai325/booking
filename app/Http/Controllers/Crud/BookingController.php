<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    use ValidationTrait;

    private const validationArray = [
        'start_time' => 'required|string',
    ];

    public function getAllBookings(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        $bookings = Booking::where('service_id', $id)->get();

        $booking = $bookings->first();
        if ($request->user()->cannot('view', $booking)) {
            abort(403);
        }

        return response()->json([
            'data' => $bookings,
        ], 200);
    }

    public function getBookingById(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        try {
            $booking = Booking::findOrFail($id);

            if ($request->user()->cannot('view', $booking)) {
                abort(403);
            }

            return response()->json([
                'data' => $booking
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Booking not found',
                'message' => $e->getMessage()
            ], 400);
        }
    }


    public function createBooking(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        $bookingData = $this->validateInputData($request, self::validationArray);
        if ($bookingData instanceof JsonResponse) {
            return $bookingData;
        }

        try {
            if (!Service::where('service_id', $id)->exists()) {
                return response()->json(['error' => 'Service not found'], 400);
            }

            $authorized = false;
            $services = $request->user()->services;
            foreach ($services as $service) {
                if ($service->getKey() === $id) {
                    $authorized = true;
                    break;
                }
            }
            if (!$authorized) {
                abort(403);
            }

            $booking = new Booking();
            $booking->fill($bookingData);
            $booking->service_id = $id;
            $booking->save();

            return response()->json([
                'message' => 'New booking inserted',
                'data' => $booking
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Insertion failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function updateBooking(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        $bookingData = $this->validateInputData($request, self::validationArray);
        if ($bookingData instanceof JsonResponse) {
            return $bookingData;
        }

        try {
            $booking = Booking::findOrFail($id);

            if ($request->user()->cannot('update', $booking)) {
                abort(403);
            }

            $booking->fill($bookingData);
            $booking->save();

            return response()->json([
                'message' => 'Booking updated',
                'data' => $booking
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Booking not found',
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $exception) {

            return response()->json([
                'error' => 'Update booking failed',
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function deleteBooking(Request $request): JsonResponse {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        try {
            $booking = Booking::findOrFail($id);

            if ($request->user()->cannot('delete', $booking)) {
                abort(403);
            }

            $records = $booking->records;
            foreach ($records as $record) {
                $record->delete();
            }
            $booking->delete();

            return response()->json([
                'message' => 'Booking deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Booking not found',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getAvailableBookings(Service $service): Collection
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

                return $count >= $capacity;
            });
    }
}
