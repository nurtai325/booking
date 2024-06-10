<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController
{
    public function webhook(Request $request) {
        Log::info($request->getBody()->toString());

        $data = $request->input('hub.challenge');
        return $data;
    }
}
