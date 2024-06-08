<?php

namespace App\Http\Controllers\Crud;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ValidationTrait;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        $services = Service::where('user_id', $id)->get();

        $service = $services->first();
        if ($request->user()->cannot('view', $service)) {
            abort(403);
        }

        return response()->json([
            'data' => $services,
        ], 200);
    }

    public function getServiceById(Request $request): JsonResponse
    {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        try {
            $service = Service::findOrFail($id);

            if ($request->user()->cannot('view', $service)) {
                abort(403);
            }

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

        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        try {
            if (!User::where('id', $id)->exists()) {
                return response()->json(['error' => 'User not found'], 400);
            }

            if ($request->user()->getKey() !== $id) {
                abort(403);
            }

            $service = new Service();
            $service->fill($serviceData);
            $service->user_id = $id;
            $service->save();

            return response()->json([
                'message' => 'New service inserted',
                'data' => $service
            ], 200);
        } catch (\Exception $exception) {

            return response()->json([
                'error' => 'Insertion failed',
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function updateService(Request $request): JsonResponse
    {
        $serviceData = $this->validateInputData($request, self::validationArray);
        if ($serviceData instanceof JsonResponse) {
            return $serviceData;
        }

        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        try {
            $service = Service::findOrFail($id);

            if ($request->user()->cannot('update', $service)) {
                abort(403);
            }

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
            ], 400);
        }
    }

    public function deleteService(Request $request): JsonResponse {
        $id = $this->validateId($request);
        if ($id instanceof JsonResponse) {
            return $id;
        }

        try {
            $service = Service::findOrFail($id);

            if ($request->user()->cannot('delete', $service)) {
                abort(403);
            }

            Booking::where('service_id', $id)->delete();
            $service->delete();

            return response()->json([
                'message' => 'Service deleted'
            ], 200);
        } catch (ModelNotFoundException|\Exception $e) {
            return response()->json([
                'error' => 'Service not found',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
