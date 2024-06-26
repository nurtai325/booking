<?php

use App\Http\Controllers\RecordController;
use App\Http\Controllers\ScheduleController;
use App\Models\Message;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__ . '/crud.php';

Route::get('/schedule', [ScheduleController::class, 'getFullSchedule'])
    ->middleware('auth:sanctum');

Route::post('/book', [RecordController::class, 'book'])
    ->middleware('auth:sanctum');
Route::post('/unbook', [RecordController::class, 'unBook'])
    ->middleware('auth:sanctum');

Route::get('/messages', function () {
    return response()->json(Message::all());
});

Route::get('/records', function () {
    return response()->json(Record::all());
});
