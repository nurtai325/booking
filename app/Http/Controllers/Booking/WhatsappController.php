<?php

namespace App\Http\Controllers\Booking;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsappController
{
    public function verify(Request $request) {
        $url = $request->getQueryString();
        $ch = "";

        $found = false;
        foreach (str_split($url) as $i) {
            if (!$found) {
                if ($i === '=') {
                    $found = true;
                    continue;
                }
            } else {
                if ($i === '&') {
                    break;
                }
            }

            if ($found) {
                $ch .= $i;
            }
        }

        return $ch;
    }

    public function message(Request $request) {
        $data = $request->json('entry.0.changes.0.value.messages.0');
        Log::info(json_encode($data));
        Log::info($data->get('from'));
        Log::info($data->get('text.body'));

    }
}
