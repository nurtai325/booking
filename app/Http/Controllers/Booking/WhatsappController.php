<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController
{
    public function webhook(Request $request) {
        $data = $request->input('hub.challenge');
        Log::info($data);
        return response($data);
    }
}
