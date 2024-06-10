<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

trait ValidationTrait
{
    private function validateId($request):JsonResponse | int
    {
        $id = $request->input('id');
        $id = (int) $id;
        if (is_null($id) |  $id == 0) {
            return response()->json([
                'error' => "id must be an integer and can't be 0"
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
            return response()->json([
                'error' => 'data is empty',
                'data' => $data,
            ], 400);
        }

        $validator = Validator::make($data, $validationArray);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        return $data;
    }

    public function validateCreationDate():\Closure
    {
        return function (Model $model) {
                $creation_date_string = $model->created_at;

                $creation_date = Carbon::create($creation_date_string)->toDateString();
                $now = Carbon::now()->toDateString();

                return $now !== $creation_date;
        };
    }

}
