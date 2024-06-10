<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController
{
    public function webhook(Request $request) {
        $data = $request->query('hub.challenge');
        Log::info($data);
        Log::info($request->fullUrl());
        Log::info($request->integer('hub.challenge'));
        return $data;
    }
}
