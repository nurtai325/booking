<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController
{
    public function webhook(Request $request) {
        $data = $request->getPayload();
        Log::info($data->get('hub.challenge'));
        Log::info($request->fullUrl());
        Log::info($request->integer('hub.challenge'));
        return response($data->get('hub.challenge'));
    }
}
