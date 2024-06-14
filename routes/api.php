<?php

use App\Http\Controllers\Booking\BookingManager;
use App\Http\Controllers\Booking\ScheduleManager;
use App\Http\Controllers\ExternalAPI\WhatsappController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

require __DIR__ . '/crud.php';

// Booking for bots
Route::get('/schedule', [ScheduleManager::class, 'getFullSchedule']);

// Whatsapp
Route::get('/webhooks', [WhatsappController::class, 'verify']);
Route::post('/webhooks', [WhatsappController::class, 'webHook']);
