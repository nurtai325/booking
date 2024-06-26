<?php

// Services
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Crud\ServiceGroupController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

// Services
    Route::get('/service/getAll', [ServiceController::class, 'getAllServices']);

    Route::get('/service/getOne', [ServiceController::class, 'getServiceById']);

    Route::put('/service/create', [ServiceController::class, 'createService']);

    Route::patch('/service/update', [ServiceController::class, 'updateService']);

    Route::delete('/service/delete', [ServiceController::class, 'deleteService']);

// Bookings

    Route::get('/booking/getAll', [BookingController::class, 'getAllBookings']);

    Route::get('/booking/getOne', [BookingController::class, 'getBookingById']);

    Route::put('/booking/create', [BookingController::class, 'createBooking']);

    Route::patch('/booking/update', [BookingController::class, 'updateBooking']);

    Route::delete('/booking/delete', [BookingController::class, 'deleteBooking']);
});
