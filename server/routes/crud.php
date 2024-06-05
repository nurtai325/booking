<?php

// Services
use App\Http\Controllers\Crud\BookingController;
use App\Http\Controllers\Crud\ServiceController;
use App\Http\Controllers\Crud\ServiceGroupController;
use Illuminate\Support\Facades\Route;

// Services
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/service/getAll', [ServiceController::class, 'getAllServices']);

    Route::get('/service/getOne', [ServiceController::class, 'getServiceById']);

    Route::put('/service/create', [ServiceController::class, 'createService']);

    Route::post('/service/update', [ServiceController::class, 'updateService']);

    Route::delete('/service/delete', [ServiceController::class, 'deleteService']);
});

// Bookings
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/booking/getAll', [BookingController::class, 'getAllBookings']);

    Route::get('/booking/getOne', [BookingController::class, 'getBookingById']);

    Route::put('/booking/create', [BookingController::class, 'createBooking']);

    Route::post('/booking/update', [BookingController::class, 'updateBooking']);

    Route::delete('/booking/delete', [BookingController::class, 'deleteBooking']);
});
