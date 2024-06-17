<?php

namespace App\Booking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Record;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class BookingManager extends Controller
{
    use ValidationTrait;

    private const array validationArray = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'additional_info' => 'nullable|string',
    ];

    public function book(int $id, string $name, string $phone, string $additional_info): JsonResponse {
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

            $bookingData = [
                'name' => $name,
                'phone' => $phone,
                'additional_info' => $additional_info,
            ];

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

    public function unBook(int $id): JsonResponse
    {
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

}
