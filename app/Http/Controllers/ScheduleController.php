<?php

namespace App\Http\Controllers;

use App\Booking\ScheduleManager;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    use ValidationTrait;

    public function getFullSchedule(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        $scheduleManager = new ScheduleManager();
        $data = $scheduleManager->getFullSchedule($id);

        if ($data->isEmpty()) {
            return response()->json([
                'error' => "user doesn't have any services"
            ], 400);
        }

        return response()->json([
            'message' => 'schedule for the user is provided',
            'data' => $data,
        ],200);
    }
}
