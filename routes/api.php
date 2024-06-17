<?php

use App\Booking\ScheduleManager;
use App\Http\Controllers\ScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__ . '/crud.php';

Route::get('/schedule', [ScheduleController::class, 'getFullSchedule'])
    ->middleware('auth:sanctum');

Route::post('/webhook', function (Request $request) {
    var_dump($request->all());
});
