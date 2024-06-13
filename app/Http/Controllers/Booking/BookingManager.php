<?php

namespace App\Http\Controllers\Booking;

use App\Events\BookingReceived;
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

            BookingReceived::dispatch($record, $booking->service->user->getKey());

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

            BookingReceived::dispatch($record);

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
