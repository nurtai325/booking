<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{
    private function validateId($request):JsonResponse | int
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

        return $id;
    }

    public function validateInputData(Request $request,  array $validationArray): JsonResponse | array {
        if (!$request->isJson()) {
            return response()->json(['error' => 'Request payload is not json'], 400);
        }

        $data = $request->json('data');

        if (is_null($data)) {
            return response()->json(['error' => 'data is empty'], 400);
        }

        $validator = Validator::make($data, $validationArray);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        return $data;
    }

    public function validateIdArray(Request $request):JsonResponse | array {
        if (!$request->isJson()) {
            return response()->json(['error' => 'Request payload is not json'], 400);
        }

        $id = $request->input('id');
        if (is_null($id) | !is_array($id) | !is_int(reset($id))) {
            return response()->json([
                'error' => 'id must be an integer array'
            ], 400);
        }

        return $id;
    }
}