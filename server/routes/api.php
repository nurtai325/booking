<?php

use App\Http\Controllers\Booking\BookingManager;
use App\Http\Controllers\Crud\ServiceGroupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/crud.php';

// Booking for bots
Route::post('/book', [BookingManager::class, 'book']);
Route::post('/unbook', [BookingManager::class, 'unBook']);
Route::get('/schedule', [BookingManager::class, 'getSchedule']);
