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

// Service Groups
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/serviceGroup/getAll', [ServiceGroupController::class, 'getAllServiceGroups']);

    Route::get('/serviceGroup/getOne', [ServiceGroupController::class, 'getServiceGroupById']);

    Route::put('/serviceGroup/create', [ServiceGroupController::class, 'createServiceGroup']);

    Route::post('/serviceGroup/update', [ServiceGroupController::class, 'updateServiceGroup']);

    Route::delete('/serviceGroup/delete', [ServiceGroupController::class, 'deleteServiceGroup']);
});


// Bookings
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/booking/getAll', [BookingController::class, 'getAllBookings']);

    Route::get('/booking/getOne', [BookingController::class, 'getBookingById']);

    Route::put('/booking/create', [BookingController::class, 'createBooking']);

    Route::post('/booking/update', [BookingController::class, 'updateBooking']);

    Route::delete('/booking/delete', [BookingController::class, 'deleteBooking']);
});
