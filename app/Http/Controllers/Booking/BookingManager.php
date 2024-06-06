<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Record;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingManager extends Controller
{
    use ValidationTrait;

    private const validationArray = [
        'name' => 'required|string',
        'phone' => 'required|string',
        'additional_info' => 'required|string',
    ];

    public function book(Request $request): JsonResponse
    {
        $id_array = $this->validateIdArray($request);
        if (!is_array($id_array)) {
            return $id_array;
        }

        $booked = [];
        foreach ($id_array as $id) {
            if ($this->bookOne($id, $request)) {
                $booked[] = $id;
            }
        }

        return response()->json([
            'message' => 'successfully booked',
            'data' => $booked
        ], 200);
    }

    public function bookOne($id, $request): bool | JsonResponse {
        try {
            $booking = Booking::findOrFail($id);
            $booked = Record::where('booking_id', $id)->count();
            $service = $booking->service()->getModel();

            if ($booked >= $service->getAttribute('capacity')) {
                return response()->json([
                    'message' => 'already booked',
                ], 400);
            } else {
                $bookingData = $this->validateInputData($request, self::validationArray);
                if ($bookingData instanceof JsonResponse) {
                    return $bookingData;
                }

                $record = new Record();
                $record->fill($bookingData);
                $record->setAttribute('booking_id', $id);
                $record->save();

            }

            return true;
        } catch (ModelNotFoundException|\Exception $e) {
            return false;
        }
    }

    public function unBook(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if (!is_int($id)) {
            return $id;
        }

        try {
            $record = Booking::findOrFail($id)->
                records()->where('record_id', $id);
            $record->delete();

            return response()->json([
                'message' => 'successfully unbooked',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Booking not found'], 400);
        }
    }

    // todo add new getschedule method for the frontend
    public function getSchedule(Request $request): JsonResponse {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        $data = new Collection();
        $services = Service::where('user_id', $id)->get();

        if (count($services) == 0) {
            return response()->json(['error' => 'service not found'], 400);
        }

        foreach ($services as $service) {
            $bookingInfo = new BookingInfo($service);

            $data->add($bookingInfo);
        }

        return response()->json([
            'message' => 'schedule for the user is provided',
            'data' => $data,
        ],200);
    }
}
