<?php

use App\Http\Controllers\Booking\WhatsappController;
use Illuminate\Http\Request;
use App\Http\Controllers\Booking\BookingManager;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__ . '/crud.php';

// Booking for bots
    Route::post('/book', [BookingManager::class, 'book']);
    Route::post('/unbook', [BookingManager::class, 'unBook']);
    Route::get('/schedule', [BookingManager::class, 'getSchedule']);

Route::get('/webhooks', [WhatsappController::class, 'verify']);
Route::post('/webhooks', [WhatsappController::class, 'message']);
