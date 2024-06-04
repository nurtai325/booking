<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationTrait;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use ValidationTrait;

    private const validationArray = [
        'name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required',
        'duration' => 'required|integer',
        'capacity' => 'required|integer',
    ];

    public function getAllServices(Request $request): JsonResponse
    {
        if (!$request->isJson()) {
            return response()->json(['error' => 'Request payload is not json'], 400);
        }

        $id = $request->input('id');
        if (is_null($id) | !is_int($id)) {
            return response()->json([
                'error' => 'id must be an integer'
            ], 400);
        }

        $services = Service::where('user_id', $id)->get();
        return response()->json([
            'data' => $services,
        ], 200);
    }

    public function getServiceById(Request $request): JsonResponse
    {
        if (!$request->isJson()) {
            return response()->json(['error' => 'Request payload is not json'], 400);
        }

        $id = $request->input('id');
        if (is_null($id) | !is_int($id)) {
            return response()->json([
                'error' => 'id must be an integer'
            ], 400);
        }

        try {
            $service = Service::findOrFail($id);

            return response()->json([
                'data' => $service
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function createService(Request $request): JsonResponse
    {
        $serviceData = $this->validateInputData($request, self::validationArray);
        if ($serviceData instanceof JsonResponse) {
            return $serviceData;
        }

        $id = $request->input('id');
        if (is_null($id) | !is_int($id)) {
            return response()->json([
                'error' => 'id must be an integer'
            ], 400);
        }

        try {
            if (!User::where('id', $id)->exists()) {
                return response()->json(['error' => 'User not found'], 400);
            }
            $service = new Service();

            $service->fill($serviceData);
            $service->save();

            return response()->json([
                'message' => 'New service inserted',
                'data' => $service
            ], 200);
        } catch (\Exception $exception) {

            return response()->json([
                'error' => 'Insertion failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function updateService(Request $request): JsonResponse
    {
        $serviceData = $this->validateInputData($request, self::validationArray);
        if ($serviceData instanceof JsonResponse) {
            return $serviceData;
        }

        $id = $request->input('id');
        if (is_null($id) | !is_int($id)) {
            return response()->json([
                'error' => 'id must be an integer'
            ], 400);
        }

        try {
            $service = Service::findOrFail($id);

            $service->fill($serviceData);
            $service->save();

            return response()->json([
                'message' => 'Service updated',
                'data' => $service
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $exception) {

            return response()->json([
                'error' => 'Update service failed',
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function deleteService(Request $request): JsonResponse {
        if (!$request->isJson()) {
            return response()->json(['error' => 'Request payload is not json'], 400);
        }

        $id = $request->input('id');
        if (is_null($id) | !is_int($id)) {
            return response()->json([
                'error' => 'id must be an integer'
            ], 400);
        }

        try {
            $service = Service::findOrFail($id);
            $service->delete();

            return response()->json([
                'message' => 'Service deleted'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
